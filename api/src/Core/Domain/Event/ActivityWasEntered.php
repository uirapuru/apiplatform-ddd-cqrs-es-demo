<?php
declare(strict_types=1);

namespace App\Core\Domain\Event;

use App\Core\Domain\DomainEvent;
use Prooph\EventStore\EventId;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class ActivityWasEntered implements DomainEvent
{
    private UuidInterface $id;
    private array $payload;

    public function __construct(UuidInterface $activityId, UuidInterface $memberId)
    {
        $this->id = Uuid::uuid4();
        $this->payload["activityId"] = $activityId;
        $this->payload["memberId"] = $memberId;
    }

    public function eventId(): ?string
    {
        // TODO: Implement eventId() method.
    }

    public function eventType(): string
    {
        // TODO: Implement eventType() method.
    }

    public function toArray(): array
    {
        // TODO: Implement toArray() method.
    }

    public static function from(EventId $eventId, array $data): DomainEvent
    {
        // TODO: Implement from() method.
    }

    public function memberId() : UuidInterface
    {
        return Uuid::fromString($this->payload["memberId"]);
    }

    public function activityId() : UuidInterface
    {
        return Uuid::fromString($this->payload["activityId"]);
    }
}
