<?php
declare(strict_types=1);

namespace App\Entry\Domain\Command;

use App\Common\Enum\EntryType;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

final class CreateEntry
{
    private UuidInterface $id;
    private UuidInterface $memberId;
    private UuidInterface $activityId;
    private DateTimeImmutable $datetime;
    private EntryType $type;

    public function __construct(
        UuidInterface $id,
        UuidInterface $memberId,
        UuidInterface $activityId,
        EntryType $type,
        DateTimeImmutable $datetime
    ) {
        $this->id = $id;
        $this->memberId = $memberId;
        $this->activityId = $activityId;
        $this->datetime = $datetime;
        $this->type = $type;
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function memberId(): UuidInterface
    {
        return $this->memberId;
    }

    public function activityId(): UuidInterface
    {
        return $this->activityId;
    }

    public function datetime(): DateTimeImmutable
    {
        return $this->datetime;
    }

    public function type() : EntryType
    {
        return $this->type;
    }
}
