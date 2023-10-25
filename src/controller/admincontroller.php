<?php

namespace Yosimar\Corona\Controller;

use Yosimar\Corona\Service\RouteService;
use Yosimar\Corona\Service\UserService;
use Yosimar\Corona\Service\StoreService;

use Exception;

class AdminController
{
    public static function findAllRoutesData(): array
    {
        $routeservices = new RouteService();
        return $routeservices->findAll();
    }

    public static function findAllUsersData(): array
    {
        $userservices = new UserService();
        return $userservices->findAll();
    }

    public static function findAllStoresData(): array
    {
        $storeservices = new StoreService();
        return $storeservices->findAll();
    }

    public static function saveRoute(): bool
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $name = $data['name'];
            $operador = $data['operador'];
            $routeService = new RouteService();
            return $routeService->save($name,$operador);
        } catch (Exception $e) {
            return FALSE;
        }
    }

    public static function saveUser(): bool
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $name = $data['name'];
            $username = $data['username'];
            $password = $data['password'];
            $userService = new UserService();
            return $userService->save($username,$name,$password);
        } catch (Exception $e) {
            return FALSE;
        }
    }

    public static function saveStore(): bool
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $branch = $data['branch'];
            $store = $data['store'];
            $storeService = new StoreService();
            return $storeService->save($branch,$store);
        } catch (Exception $e) {
            return FALSE;
        }
    }

    public static function deleteRoute(): bool
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $id = $data['id'];
            $routeService = new RouteService();
            return $routeService->deleteById((int) $id);
        } catch (Exception $e) {
            return FALSE;
        }
    }

    public static function deleteUser(): bool
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $id = $data['id'];
            $userService = new UserService();
            return $userService->deleteById((int) $id);
        } catch (Exception $e) {
            return FALSE;
        }
    }

    public static function deleteStore(): bool
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $id = $data['id'];
            $storeService = new StoreService();
            return $storeService->deleteById((int) $id);
        } catch (Exception $e) {
            return FALSE;
        }
    }

}