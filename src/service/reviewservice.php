<?php

namespace Yosimar\Corona\Service;

use Yosimar\Corona\Core\Database;
use Yosimar\Corona\Model\Review;
use PDO;
use PDOException;

class ReviewService
{

    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function findById(int $idReview): ?Review
    {
        try {
            $reviewQuery = $this->db->prepare("SELECT * FROM review  WHERE id = :id");
            $reviewQuery->execute(['id' => $idReview]);
            $review = new Review();

            if ($reviewQuery->rowCount() == 1) {
                $row = $reviewQuery->fetch(PDO::FETCH_ASSOC);
                $review->setId((int) $row['id']);
                $review->setFolio($row['folio']);
                $review->setIdUser((int) $row['id_user']);
                $review->setIdRoute((int) $row['id_route']);
                $review->setDate($row['date_review']);
                $review->setObservation($row['observation']);
                $review->setSignature($row['signature']);
            }
            return $review;
        } catch (PDOException $e) {
            error_log("ReviewService::findById -> Error al obtener la revision por id");
            error_log("Error: " . $e);
            return NULL;
        }
    }

    public function findLast(): string
    {
        try {
            $idLasReview = $this->db->query('SELECT * FROM review ORDER BY id DESC LIMIT 1');
            $folioReview = '';
            $idReview = '';
            if ($idLasReview->rowCount() == 1) {
                $row = $idLasReview->fetch(PDO::FETCH_ASSOC);
                $idReview = $row['id'];
                for ($i = 6; $i > strlen((string) $idReview); $i--) {
                    $folioReview .= '0';
                }
            } else {
                $folioReview .= '000000';
            }
            $dateNow = date("ymd");
            return $dateNow . $folioReview . $idReview;
        } catch (PDOException $e) {
            error_log('ReviewService::findLast -> error obtener el folio de la revision');
            error_log("Error: " . $e);
            return '';
        }
    }

    public function findLastId(): string
    {
        try {
            $idLasReview = $this->db->query('SELECT * FROM review ORDER BY id DESC LIMIT 1');
            $idReview = '';
            if ($idLasReview->rowCount() == 1) {
                $row = $idLasReview->fetch(PDO::FETCH_ASSOC);
                $idReview = $row['id'];
            }
            return $idReview;
        } catch (PDOException $e) {
            error_log('ReviewService::findLastId -> error obtener el id de la revision');
            error_log("Error: " . $e);
            return '';
        }
    }

    public function findAll(): array
    {
        try {
            $reviewQuery = $this->db->query("SELECT r.folio as folio, ro.name as route_name, r.date_review as date_review, u.name as supervisor_name, r.id as id_review 
            FROM review r, route ro, user u WHERE r.id_route = ro.id and r.id_user = u.id");
            $reviews = [];

            while ($row = $reviewQuery->fetch(PDO::FETCH_ASSOC)) {
                $review = [
                    'id' => $row['id_review'],
                    'folio' => $row['folio'],
                    'id_user' => $row['supervisor_name'],
                    'route' => $row['route_name'],
                    'date_review' => substr($row['date_review'], 0, 10),
                ];
                $reviews[] = $review;
            }
            return $reviews;
        } catch (PDOException $e) {
            error_log("ReviewService::findAll -> Error al obtener las revisiones");
            error_log("Error: " . $e);
            return [];
        }
    }

    public function findByDate(string $date): array
    {
        try {
            $date = $date == '' ? date("Y-m-d") : date($date);
            $reviewQuery = $this->db->prepare("SELECT r.folio as folio, ro.name as route_name, r.date_review as date_review, u.name as supervisor_name, r.id as id_review 
            FROM review r, route ro, user u WHERE r.id_route = ro.id and r.id_user = u.id and r.date_review LIKE :date");
            $reviewQuery->execute(["date" => $date . '%']);
            $reviews = [];

            while ($row = $reviewQuery->fetch(PDO::FETCH_ASSOC)) {
                $review = [
                    'id' => $row['id_review'],
                    'folio' => $row['folio'],
                    'id_user' => $row['supervisor_name'],
                    'route' => $row['route_name'],
                    'date_review' => substr($row['date_review'], 0, 10),
                ];
                $reviews[] = $review;
            }
            return $reviews;
        } catch (PDOException $e) {
            error_log("ReviewService::findByDate -> Error al obtener las revisiones por fecha");
            error_log("Error: " . $e);
            return [];
        }
    }

    public function save(int $routeId, string $observation, int $idUser, array $return_bottles, array $return_products, array $missing_bottles, array $shelters, string $signature): bool
    {
        try {

            $date = date("Y-m-d H:i:s");
            $folio = $this->findLast();

            $this->db->beginTransaction();

            $query = $this->db->prepare('INSERT INTO review (folio, id_user, id_route, date_review, observation, signature)
            VALUES (:folio, :id_user, :id_route, :date, :observation, :signature)');
            $query->execute([
                'folio' => $folio,
                'id_user' => $idUser,
                'id_route' => $routeId,
                'date' => $date,
                'observation' => $observation,
                'signature' => $signature
            ]);

            $idreview = $this->findLastId();

            foreach ($return_bottles as $id => $quantity) {
                $query = $this->db->prepare('INSERT INTO detail_return_product (id_review, id_product, quantity, type) VALUES (:id_review, :id_product, :quantity, :type)');
                $query->execute([
                    'id_review' => $idreview,
                    'id_product' => $id,
                    'quantity' => $quantity,
                    'type' => "envase",
                ]);
            }

            foreach ($return_products as $id => $quantity) {
                $query = $this->db->prepare('INSERT INTO detail_return_product (id_review, id_product, quantity, type) VALUES (:id_review, :id_product, :quantity, :type)');
                $query->execute([
                    'id_review' => $idreview,
                    'id_product' => $id,
                    'quantity' => $quantity,
                    'type' => "devolucion",
                ]);
            }

            foreach ($missing_bottles as $id => $quantity) {
                $query = $this->db->prepare('INSERT INTO detail_return_product (id_review, id_product, quantity, type) VALUES (:id_review, :id_product, :quantity, :type)');
                $query->execute([
                    'id_review' => $idreview,
                    'id_product' => $id,
                    'quantity' => $quantity,
                    'type' => "faltante",
                ]);
            }

            $shelterService = new ShelterService();
            $shelterService->save($shelters, $idreview);

            $this->db->commit();

            return TRUE;
        } catch (PDOException $e) {
            error_log('ReviewService::save-> Error al guardar la revision');
            error_log("Error: " . $e);
            $this->db->rollBack();
            return FALSE;
        }
    }

}