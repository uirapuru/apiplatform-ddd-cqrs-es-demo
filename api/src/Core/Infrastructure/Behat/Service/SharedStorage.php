<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Service;

class SharedStorage implements SharedStorageInterface
{
    private array $clipboard = [];

    private ?string $latestKey;

    public function get(string $key) {
        if (!isset($this->clipboard[$key])) {
            throw new \InvalidArgumentException(sprintf('There is no current resource for "%s"!', $key));
        }

        return $this->clipboard[$key];
    }

    public function has(string $key): bool
    {
        return isset($this->clipboard[$key]);
    }

    public function set(string $key, $resource): void
    {
        $this->clipboard[$key] = $resource;
        $this->latestKey = $key;
    }

    public function getLatestResource()
    {
        if (!isset($this->clipboard[$this->latestKey])) {
            throw new \InvalidArgumentException(sprintf('There is no "%s" latest resource!', $this->latestKey));
        }

        return $this->clipboard[$this->latestKey];
    }

    public function setClipboard(array $clipboard): void
    {
        $this->clipboard = array_merge($this->clipboard, $clipboard);
    }
}
