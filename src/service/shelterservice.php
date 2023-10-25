<?php

namespace Yosimar\Corona\Service;

use Yosimar\Corona\Core\Database;
use PDO;
use PDOException;
class ShelterService
{

    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function save($shelters, $id_review): void
    {
        try {
            foreach ($shelters as $shelter) {
                $query = $this->db->prepare("INSERT INTO shelter (id_review,id_store, id_product, quantity) VALUES (:id_review, :id_store, :id_product, :quantity)");
                $query->execute([
                    'id_review' => $id_review,
                    'id_store' => $shelter[0],
                    'id_product' => $shelter[1],
                    'quantity' => $shelter[2]
                ]);
            }
        } catch (PDOException $e) {
            error_log('ShelterService::save-> Error al guardar el resguardo');
            error_log("Error: " . $e);
        }
    }

    public function findAllByIdReview(int $idReview): array
    {
        try {
            $productQuery = $this->db->prepare("SELECT store.name as store_name, product.name as product_name, shelter.quantity as quantity FROM product, store, shelter WHERE shelter.id_review = :id_review AND shelter.id_product = product.id AND shelter.id_store = store.id");
            $productQuery->execute(['id_review' => $idReview]);
            $products = [];

            while ($row = $productQuery->fetch(PDO::FETCH_ASSOC)) {
                $product = [
                    'store' => $row['store_name'],
                    'product' => $row['product_name'],
                    'quantity' => $row['quantity']
                ];
                $products[] = $product;
            }
            return $products;
        } catch (PDOException $e) {
            error_log("ShelterService::findAllDetails -> Error al obtener los productos resguardados");
            error_log("Error: " . $e);
            return [];
        }
    }

}