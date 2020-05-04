<?php
declare(strict_types=1);

namespace App\Activity\Infrastructure\Repository;

use App\Activity\Domain\Model\Activity;
use App\Activity\Domain\Repository\ActivityRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

final class InMemoryActivityRepository implements ActivityRepositoryInterface
{
    private array $activitys = [];

    public function add(Activity $activity): void
    {
        $this->activitys[$activity->id()->toString()] = $activity;
    }

    public function remove(Activity $activity): void
    {
        unset($this->activitys[$activity->id()->toString()]);
    }

    public function find(UuidInterface $uuid): ?Activity
    {
        return $this->activitys[$uuid->toString()] ?? null;
    }

    public function size(): int
    {
        return count($this->activitys);
    }
}
