<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Service;

interface SharedStorageInterface
{
    public function get(string $key);

    public function has(string $key) : bool;

    public function set(string $key, $resource) : void;

    public function getLatestResource();

    /**
     * @throws \RuntimeException
     */
    public function setClipboard(array $clipboard);
}
