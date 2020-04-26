<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Service\Setter;

interface CookieSetterInterface
{
    public function setCookie(string $name, string $value);
}
