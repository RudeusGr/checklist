<?php

namespace Yosimar\Corona\Model;

use Yosimar\Corona\Model\User;

class Session
{
    private string $session = 'user';

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function setSession(User $user): void
    {
        $_SESSION[$this->session] = $user;
    }

    public function getSession(): User
    {
        return $_SESSION[$this->session];
    }

    public function closeSession(): void
    {
        session_unset();
        session_destroy();
    }

    public function existSession(): bool
    {
        return isset($_SESSION[$this->session]);
    }
}