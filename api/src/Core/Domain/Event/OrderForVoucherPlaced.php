<?php
declare(strict_types=1);

namespace App\Core\Domain\Event;

use App\Core\Domain\DomainEvent;
use DateTimeImmutable;
use Prooph\EventStore\EventId;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class OrderForVoucherPlaced implements DomainEvent
{
    private UuidInterface $id;
    private array $payload;

    public function __construct(UuidInterface $id, array $payload)
    {
        $this->id = $id;
        $this->payload = $payload;
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
        return $this->payload;
    }

    public static function from(EventId $eventId, array $data): DomainEvent
    {
        return new self(Uuid::fromString($eventId), $data);
    }

    public function orderId() : string
    {
        return $this->payload["orderId"];
    }

    public function customerId() : string
    {
        return $this->payload["customerId"];
    }

    public function voucherId() : string
    {
        return $this->payload["voucherId"];
    }

    public function type() : string
    {
        return $this->payload["type"];
    }

    public function startDate() : ?DateTimeImmutable
    {
        return $this->payload["startDate"];
    }

    public function endDate() : ?DateTimeImmutable
    {
        return $this->payload["endDate"];
    }

    public function entriesAmount() : ?int
    {
        return $this->payload["entriesAmount"];
    }
}
