<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Service\Setter;

use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Session;
use FriendsOfBehat\SymfonyExtension\Driver\SymfonyDriver;
use Symfony\Component\BrowserKit\Cookie;

final class CookieSetter implements CookieSetterInterface
{
    private Session $minkSession;

    private array $minkParameters;

    public function __construct(Session $minkSession, array $minkParameters = [])
    {
        if (!is_array($minkParameters) && !$minkParameters instanceof \ArrayAccess) {
            throw new \InvalidArgumentException(sprintf(
                '"$minkParameters" passed to "%s" has to be an array or implement "%s".',
                self::class,
                \ArrayAccess::class
            ));
        }

        $this->minkSession = $minkSession;
        $this->minkParameters = $minkParameters;
    }

    /**
     * {@inheritdoc}
     */
    public function setCookie($name, $value)
    {
        $this->prepareMinkSessionIfNeeded($this->minkSession);

        $driver = $this->minkSession->getDriver();

        if ($driver instanceof SymfonyDriver) {
            $driver->getClient()->getCookieJar()->set(
                new Cookie($name, $value, null, null, parse_url($this->minkParameters['base_url'], \PHP_URL_HOST))
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

        if ($driver instanceof Selenium2Driver && $driver->getWebDriverSession() === null) {
            return true;
        }

        if (false !== strpos($session->getCurrentUrl(), $this->minkParameters['base_url'])) {
            return false;
        }

        return true;
    }
}
