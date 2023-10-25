<?php

namespace Yosimar\Corona\Service;

use PDO;
use PDOException;
use Yosimar\Corona\Model\Route;
use Yosimar\Corona\Core\Database;

class RouteService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function save(string $name, string $operador): bool
    {
        try {
            $routeQuery = $this->db->prepare("SELECT * FROM route WHERE name = :name");
            $routeQuery->execute(["name" => $name]);

            if ($routeQuery->rowCount() == 1) {
                return FALSE;
            }

            $query = $this->db->prepare('INSERT INTO route (name, operador) VALUES (:name, :operador)');
            $query->execute([
                'name' => $name,
                'operador' => $operador
            ]);

            return TRUE;
        } catch (PDOException $e) {
            error_log('RouteService::save-> Error al guardar la ruta');
            error_log("Error: " . $e);
            return FALSE;
        }
    }

    public function findAll(): array
    {
        try {
            $routeQuery = $this->db->query("SELECT * FROM route");
            $routes = [];

            while ($row = $routeQuery->fetch(PDO::FETCH_ASSOC)) {
                $route = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'operador' => $row['operador'],
                ];
                $routes[] = $route;
            }
            return $routes;
        } catch (PDOException $e) {
            error_log("RouteService::findAll -> Error al obtener las rutas");
            error_log("Error: " . $e);
            return [];
        }
    }

    public function findById(int $id): ?Route
    {
        try {
            $routeQuery = $this->db->prepare("SELECT * FROM route WHERE id = :id");
            $routeQuery->execute(["id" => $id]);
            $route = new Route();

            if ($routeQuery->rowCount() == 1) {
                $row = $routeQuery->fetch(PDO::FETCH_ASSOC);
                $route->setId($row['id']);
                $route->setOperador($row['operador']);
                $route->setName($row['name']);
            }
            return $route;
        } catch (PDOException $e) {
            error_log("RouteService::findById -> Error al obtener la ruta");
            error_log("Error: " . $e);
            return NULL;
        }
    }

    public function deleteById(int $id): bool
    {
        try {
            $routeQuery = $this->db->prepare("DELETE FROM route WHERE id = :id");
            $routeQuery->execute(["id" => $id]);
            return TRUE;
        } catch (PDOException $e) {
            error_log("RouteService::deleteById -> Error al eliminar la ruta");
            error_log("Error: " . $e);
            return FALSE;
        }
    }
}