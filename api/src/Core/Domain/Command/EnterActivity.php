<?php
declare(strict_types=1);

namespace App\Core\Domain\Command;

use Ramsey\Uuid\UuidInterface;

final class EnterActivity
{
    protected UuidInterface $activityId;
    protected UuidInterface $memberId;

    public function __construct(UuidInterface $activityId, UuidInterface $memberId)
    {
        $this->activityId = $activityId;
        $this->memberId = $memberId;
    }

    public function activityId(): UuidInterface
    {
        return $this->activityId;
    }

    public function memberId(): UuidInterface
    {
        return $this->memberId;
    }
}
