<?php
declare(strict_types=1);

namespace App\Payment\Domain\Event;

use App\Core\Domain\DomainEvent;
use App\Payment\Domain\Model\Type;
use Prooph\EventStore\EventId;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class PaymentWasPaid implements DomainEvent
{
    private UuidInterface $eventId;
    private UuidInterface $paymentId;
    private Type $type;

    public function __construct(UuidInterface $eventId, UuidInterface $paymentId, Type $type)
    {
        $this->eventId = $eventId;
        $this->paymentId = $paymentId;
        $this->type = $type;
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
            "paymentId" => $this->paymentId->toString(),
            "type" => $this->type->getValue()
        ];
    }

    public static function from(EventId $eventId, array $data): DomainEvent
    {
        return new self(
            Uuid::fromString($eventId->toString()),
            Uuid::fromString($data["paymentId"]),
            new Type($data["type"])
        );
    }

    public function paymentId(): UuidInterface
    {
        return $this->paymentId;
    }

    public function type(): Type
    {
        return $this->type;
    }
}
