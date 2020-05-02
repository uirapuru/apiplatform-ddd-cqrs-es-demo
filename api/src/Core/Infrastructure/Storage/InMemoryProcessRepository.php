<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Storage;

use App\Core\Domain\Saga\ProcessManagerInterface;
use App\User\Domain\Model\CustomerInterface;
use Ramsey\Uuid\UuidInterface;

final class InMemoryProcessRepository implements ProcessRepositoryInterface
{
    private array $processes = [];

    public function add(ProcessManagerInterface $process): void
    {
        $this->processes[$process->processId()->toString()] = $process;
    }

    public function find(UuidInterface $uuid): ?ProcessManagerInterface
    {
        return $this->processes[$uuid->toString()] ?? null;
    }

    public function size(): int
    {
        return count($this->processes);
    }
}
