<?php

namespace Yosimar\Corona\Controller;

use Yosimar\Corona\Service\SessionService;
use Yosimar\Corona\Service\UserService;

class LoginController
{

    public static function login(): bool
    {
        if (self::authentication()) return TRUE;

        $userService = new UserService();
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $user = $userService->findUserByUsername($_POST['username']);
            if ($user) {
                if ($userService->comparePassword($_POST['password'], $user->getPassword())) {
                    $sessionService = new SessionService();
                    $sessionService->initSession($user);
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    public static function authentication(): bool
    {
        $sessionService = new SessionService();
        return $sessionService->authentication();
    }

    public static function logout(): void
    {
        $sessionService = new SessionService();
        $sessionService->closeSession();
    }

}