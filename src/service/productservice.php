<?php

namespace Yosimar\Corona\Service;

use PDO;
use PDOException;
use Yosimar\Corona\Core\Database;

class ProductService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function findAll(): array
    {
        try {
            $productQuery = $this->db->query("SELECT * FROM product");
            $products = [];

            while ($row = $productQuery->fetch(PDO::FETCH_ASSOC)) {
                $product = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'price_bottle' => $row['price_bottle'],
                    'type' => $row['type'],
                    'sku' => $row['sku']
                ];
                $products[] = $product;
            }
            return $products;
        } catch (PDOException $e) {
            error_log("ProductService::findAll -> Error al obtener los productos");
            error_log("Error: " . $e);
            return [];
        }
    }

    public function findAllMissingDetails(int $idReview): array
    {
        try {
            $productQuery = $this->db->prepare("SELECT product.name as name, product.price_bottle as price_bottle, detail_return_product.quantity as quantity FROM product, detail_return_product WHERE detail_return_product.id_review = :id_review AND detail_return_product.id_product = product.id AND detail_return_product.type = 'faltante'");
            $productQuery->execute(['id_review' => $idReview]);
            $products = [];

            while ($row = $productQuery->fetch(PDO::FETCH_ASSOC)) {
                $product = [
                    'name' => $row['name'],
                    'price_bottle' => $row['price_bottle'],
                    'quantity' => $row['quantity']
                ];
                $products[] = $product;
            }
            return $products;
        } catch (PDOException $e) {
            error_log("ProductService::findAllMissingDetails -> Error al obtener los detalles de los productos faltantes");
            error_log("Error: " . $e);
            return [];
        }
    }

    public function findAllDetails(int $idReview): array
    {
        try {
            $productQuery = $this->db->prepare("SELECT product.name as name, product.price_bottle as price_bottle, detail_return_product.quantity as quantity, detail_return_product.type as type FROM product, detail_return_product WHERE detail_return_product.id_review = :id_review AND detail_return_product.id_product = product.id");
            $productQuery->execute(['id_review' => $idReview]);
            $products = [];

            while ($row = $productQuery->fetch(PDO::FETCH_ASSOC)) {
                $product = [
                    'name' => $row['name'],
                    'price_bottle' => $row['price_bottle'],
                    'quantity' => $row['quantity'],
                    'type' => $row['type']
                ];
                $products[] = $product;
            }
            return $products;
        } catch (PDOException $e) {
            error_log("ProductService::findAllDetails -> Error al obtener los detalles de los productos");
            error_log("Error: " . $e);
            return [];
        }
    }
}
