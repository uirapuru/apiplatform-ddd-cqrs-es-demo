<?php
declare(strict_types=1);

namespace App\Order\Domain\Event;

use App\Core\Domain\DomainEvent;
use Prooph\EventStore\EventId;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class OrderWasCreated implements DomainEvent
{
    private UuidInterface $id;
    private UuidInterface $orderId;

    public function __construct(UuidInterface $id, UuidInterface $orderId)
    {
        $this->id = $id;
        $this->orderId = $orderId;
    }

    public function eventId(): ?string
    {
        return $this->id->toString();
    }

    public function eventType(): string
    {
        return self::class;
    }

    public function toArray(): array
    {
        return [];
    }

    public static function from(EventId $eventId, array $data): DomainEvent
    {
        return new self(
            Uuid::fromString($eventId),
            Uuid::fromString($data["orderId"])
        );
    }
}
