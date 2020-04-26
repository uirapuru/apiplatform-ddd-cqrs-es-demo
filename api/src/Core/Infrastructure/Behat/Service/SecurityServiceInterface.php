<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Service;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

interface SecurityServiceInterface
{
    /**
     * @throws \InvalidArgumentException
     */
    public function logIn(UserInterface $user): void;

    public function logOut(): void;

    /**
     * @throws TokenNotFoundException
     */
    public function getCurrentToken(): TokenInterface;

    public function restoreToken(TokenInterface $token): void;
}
