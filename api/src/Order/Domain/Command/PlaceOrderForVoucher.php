<?php
declare(strict_types=1);

namespace App\Order\Domain\Command;

use App\Core\Domain\Command;
use App\Voucher\Domain\Model\Type;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class PlaceOrderForVoucher implements Command
{
    private UuidInterface $voucherId;
    private UuidInterface $customerId;
    private Type $voucherType;
    private ?DateTimeImmutable $startDate;
    private ?DateTimeImmutable $endDate;
    private ?int $entriesAmount;

    public function __construct(
        UuidInterface $voucherId,
        UuidInterface $customerId,
        Type $voucherType,
        ?DateTimeImmutable $startDate = null,
        ?DateTimeImmutable $endDate = null,
        ?int $entriesAmount = null
    ) {
        $this->voucherId = $voucherId;
        $this->customerId = $customerId;
        $this->voucherType = $voucherType;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->entriesAmount = $entriesAmount;
    }

    public function voucherId(): UuidInterface
    {
        return $this->voucherId;
    }

    public function customerId(): UuidInterface
    {
        return $this->customerId;
    }

    public function voucherType(): Type
    {
        return $this->voucherType;
    }

    public function startDate(): ?DateTimeImmutable
    {
        return $this->startDate;
    }

    public function endDate(): ?DateTimeImmutable
    {
        return $this->endDate;
    }

    public function entriesAmount(): ?int
    {
        return $this->entriesAmount;
    }
}
