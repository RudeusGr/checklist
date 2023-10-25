<?php

namespace Yosimar\Corona\Service;

use Yosimar\Corona\Core\Database;
use PDO;
use PDOException;

class StoreService
{

    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function findAll(): array
    {
        try {
            $storeQuery = $this->db->query("SELECT * FROM store");
            $stores = [];
            while ($row = $storeQuery->fetch(PDO::FETCH_ASSOC)) {
                $store = [
                    'id' => $row['id'],
                    'code' => $row['code'],
                    'name' => $row['name']
                ];
                $stores[] = $store;
            }
            return $stores;
        } catch (PDOException $e) {
            error_log("StoreService::findAll -> Error al obtener las tiendas");
            error_log("Error: " . $e);
            return [];
        }
    }

    public function save(string $code, string $name): bool
    {
        try {
            $storeQuery = $this->db->prepare("SELECT * FROM store WHERE code = :code");
            $storeQuery->execute(["code" => $code]);

            if ($storeQuery->rowCount() == 1) {
                return FALSE;
            }

            $query = $this->db->prepare("INSERT INTO store (code, name) VALUES ( :code, :name)");
            $query->execute([
                "code" => $code,
                "name" => $name
            ]);

            return TRUE;
        } catch (PDOException $ex) {
            error_log('StoreService::save-> Error al guardar la tienda');
            error_log('Error: ' . $ex);
            return FALSE;
        }
    }

    public function deleteById(int $id): bool
    {
        try {
            $storeQuery = $this->db->prepare("DELETE FROM store WHERE id = :id");
            $storeQuery->execute(["id" => $id]);
            return TRUE;
        } catch (PDOException $e) {
            error_log("StoreService::deleteById -> Error al eliminar la tienda");
            error_log("Error: " . $e);
            return FALSE;
        }
    }

}