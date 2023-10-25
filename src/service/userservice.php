<?php

namespace Yosimar\Corona\Service;

use Exception;
use Yosimar\Corona\Core\Database;
use Yosimar\Corona\Model\User;
use PDO;
use PDOException;

class UserService
{

    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function save(string $username, string $name, string $password): bool
    {
        try {
            $userQuery = $this->db->prepare("SELECT * FROM user WHERE username = :username");
            $userQuery->execute(["username" => $username]);

            if ($userQuery->rowCount() == 1) {
                return FALSE;
            }

            $passwordHash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);

            $query = $this->db->prepare("INSERT INTO user (username, password, name, admin) VALUES ( :username, :password, :name, 0)");
            $query->execute([
                "username" => $username,
                "name" => $name,
                "password" => $passwordHash
            ]);

            return TRUE;
        } catch (PDOException $ex) {
            error_log('UserService::save-> Error al guardar el usuario');
            error_log('Error: ' . $ex);
            return FALSE;
        }
    }

    public function findAll(): array
    {
        try {
            $sessionService = new SessionService();
            $userCurrent = $sessionService->getSessionData();
            $userQuery = $this->db->prepare("SELECT * FROM user WHERE id <> :id");
            $userQuery->execute(["id" => $userCurrent->getId()]);
            $users = [];

            while ($row = $userQuery->fetch(PDO::FETCH_ASSOC)) {
                $user = [
                    'id' => $row['id'],
                    'username' => $row['username'],
                    'name' => $row['name'],
                ];
                $users[] = $user;
            }
            return $users;
        } catch (PDOException $e) {
            error_log("UserService::findAll -> Error al obtener los usuarios");
            error_log("Error: " . $e);
            return [];
        }
    }

    public function findUserByUsername(string $username): ?User
    {
        try {
            $userQuery = $this->db->prepare("SELECT * FROM user WHERE username = :username");
            $userQuery->execute(["username" => $username]);
            $user = new User();

            if ($userQuery->rowCount() == 1) {
                $row = $userQuery->fetch(PDO::FETCH_ASSOC);
                $user->setId($row['id']);
                $user->setUsername($row['username']);
                $user->setPassword($row['password']);
                $user->setName($row['name']);
            }
            return $user;
        } catch (PDOException $e) {
            error_log("UserService::findUserByUsername -> Error al obtener el usuario");
            error_log("Error: " . $e);
            return NULL;
        }
    }

    public function deleteById(int $id): bool
    {
        try {
            $userQuery = $this->db->prepare("DELETE FROM user WHERE id = :id AND admin = 0");
            $userQuery->execute(["id" => $id]);
            return TRUE;
        } catch (PDOException $e) {
            error_log("UserService::deleteById -> Error al eliminar el usuario");
            error_log("Error: " . $e);
            return FALSE;
        }
    }

    public function comparePassword(string $password, string $passwordHash): bool
    {
        try {
            return password_verify($password, $passwordHash);
        } catch (Exception $e) {
            error_log("UserService::comparePassword -> error al comparar las contraseñas");
            error_log("Error: " . $e);
            return FALSE;
        }
    }
}