<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Service\Setter;

use Behat\Mink\Session;
use FriendsOfBehat\SymfonyExtension\Driver\SymfonyDriver;
use FriendsOfBehat\SymfonyExtension\Mink\MinkParameters;
use Symfony\Component\BrowserKit\Cookie;

final class CookieSetter implements CookieSetterInterface
{
    private Session $minkSession;
    private MinkParameters $minkParameters;

    public function __construct(Session $minkSession, MinkParameters $minkParameters)
    {
        $this->minkSession = $minkSession;
        $this->minkParameters = $minkParameters;
    }

    public function setCookie($name, $value) : void
    {
        $this->prepareMinkSessionIfNeeded($this->minkSession);

        $driver = $this->minkSession->getDriver();

        if ($driver instanceof SymfonyDriver) {
            $url = $this->minkParameters->offsetGet('base_url');
            $baseUrl = parse_url($url, \PHP_URL_HOST);

            $driver->getBrowser()->getCookieJar()->set(
                new Cookie($name, $value, null, null, $baseUrl)
            );

            return;
        }

        $this->minkSession->setCookie($name, $value);
    }

    private function prepareMinkSessionIfNeeded(Session $session): void
    {
        if ($this->shouldMinkSessionBePrepared($session)) {
            $session->visit(rtrim($this->minkParameters['base_url'], '/') . '/');
        }
    }

    private function shouldMinkSessionBePrepared(Session $session): bool
    {
        $driver = $session->getDriver();

        if ($driver instanceof SymfonyDriver) {
            return false;
        }

        if (false !== strpos($session->getCurrentUrl(), $this->minkParameters['base_url'])) {
            return false;
        }

        return true;
    }
}
