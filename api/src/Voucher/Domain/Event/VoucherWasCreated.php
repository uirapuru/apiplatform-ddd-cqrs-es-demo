<?php
declare(strict_types=1);

namespace App\Voucher\Domain\Event;

use App\Core\Domain\DomainEvent;
use Prooph\EventStore\EventId;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class VoucherWasCreated implements DomainEvent
{
    private UuidInterface $voucherId;
    private array $payload = [];

    public function __construct(UuidInterface $voucherId, array $payload)
    {
        $this->voucherId = $voucherId;
        $this->payload = $payload;
    }

    public function eventId(): ?string
    {
        return $this->voucherId->toString();
    }

    public function eventType(): string
    {
        // TODO: Implement eventType() method.
    }

    public function toArray(): array
    {
        return [];
    }

    public static function from(EventId $eventId, array $data): DomainEvent
    {
        return new self(Uuid::fromString($eventId->toString()), $data);
    }
}
