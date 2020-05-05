<?php
declare(strict_types=1);

namespace App\Core\Domain\Event;

use App\Core\Domain\DomainEvent;
use Prooph\EventStore\EventId;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class PaymentWasRejected implements DomainEvent
{
    private UuidInterface $eventId;
    private UuidInterface $paymentId;

    public function __construct(UuidInterface $eventId, UuidInterface $paymentId)
    {
        $this->eventId = $eventId;
        $this->paymentId = $paymentId;
    }

    public function eventId(): ?string
    {
        return $this->eventId->toString();
    }

    public function eventType(): string
    {
        return self::class;
    }

    public function toArray(): array
    {
        return [
            "paymentId" => $this->paymentId->toString()
        ];
    }

    public static function from(EventId $eventId, array $data): DomainEvent
    {
        return new self(
            Uuid::fromString($eventId->toString()), Uuid::fromString($data["paymentId"])
        );
    }

    public function paymentId(): UuidInterface
    {
        return $this->paymentId;
    }
}
