<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Service;

use App\Core\Infrastructure\Behat\Service\Setter\CookieSetterInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

final class SecurityService implements SecurityServiceInterface
{
    private SessionInterface $session;

    private CookieSetterInterface $cookieSetter;

    private string $sessionTokenVariable;

    private string $firewallContextName;

    public function __construct(SessionInterface $session, CookieSetterInterface $cookieSetter, string $firewallContextName = 'default')
    {
        $this->session = $session;
        $this->cookieSetter = $cookieSetter;
        $this->sessionTokenVariable = sprintf('_security_%s', $firewallContextName);
        $this->firewallContextName = $firewallContextName;
    }

    public function logIn(UserInterface $user): void
    {
        $token = new UsernamePasswordToken($user, $user->getPassword(), $this->firewallContextName, $user->getRoles());
        $this->setToken($token);
    }

    public function logOut(): void
    {
        $this->session->set($this->sessionTokenVariable, null);
        $this->session->save();

        $this->cookieSetter->setCookie($this->session->getName(), $this->session->getId());
    }

    public function getCurrentToken(): TokenInterface
    {
        $serializedToken = $this->session->get($this->sessionTokenVariable);

        if (null === $serializedToken) {
            throw new TokenNotFoundException();
        }

        return unserialize($serializedToken);
    }

    public function restoreToken(TokenInterface $token): void
    {
        $this->setToken($token);
    }

    private function setToken(TokenInterface $token)
    {
        $serializedToken = serialize($token);
        $this->session->set($this->sessionTokenVariable, $serializedToken);
        $this->session->save();
        $this->cookieSetter->setCookie($this->session->getName(), $this->session->getId());
    }
}
