<?php

namespace Yosimar\Corona\Service;

use Yosimar\Corona\Model\Session;
use Yosimar\Corona\Model\User;

class SessionService
{
    private Session $userSession;

    public function __construct()
    {
        $this->userSession = new Session();
    }

    public function initSession(User $user): void
    {
        $this->userSession->setSession($user);
    }

    public function authentication(): bool
    {
        if ($this->userSession->existSession()) {
            return TRUE;
        }
        return FALSE;
    }

    public function getSessionData(): User
    {
        return $this->userSession->getSession();
    }

    public function closeSession(): void
    {
        $this->userSession->closeSession();
    }

}