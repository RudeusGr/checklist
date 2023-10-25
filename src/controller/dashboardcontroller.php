<?php

namespace Yosimar\Corona\Controller;

use Yosimar\Corona\Service\RouteService;
use Yosimar\Corona\Service\ReviewService;
use Yosimar\Corona\Service\SessionService;
use Yosimar\Corona\Service\ProductService;

use Exception;
use Yosimar\Corona\Service\storeService;

class DashboardController
{
    public static function findAllDashboardData(): array
    {
        $routeService = new RouteService();
        $allRoutes = $routeService->findAll();

        $reviewService = new ReviewService();
        $folioReview = $reviewService->findLast();

        $productService = new ProductService();
        $allProducts = $productService->findAll();

        $storeService = new StoreService();
        $allStores = $storeService->findAll();

        return [$allRoutes, $folioReview, $allProducts, $allStores];
    }

    public static function saveReview(): bool
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            $routeId = (int) $data['route'];
            $observation = $data['observation'];
            $return_bottles = $data['return_bottles'];
            $return_products = $data['return_products'];
            $missing_bottles = $data['missing_bottles'];
            $shelters = $data['shelters'];

            $sesionService = new SessionService();
            $userSession = $sesionService->getSessionData();
            $idUser = (int) $userSession->getId();

            $img64 = $data['signature'];
            $img = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img64));
            $file = 'src/public/signatures/' . uniqid() . '.png';
            if (!file_put_contents($file, $img)) {
                return FALSE;
            }

            $reviewService = new ReviewService();
            $saveReview = $reviewService->save($routeId, $observation, $idUser, $return_bottles, $return_products, $missing_bottles, $shelters, $file);

            if ($saveReview) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Exception $e) {
            return FALSE;
        }
    }
}