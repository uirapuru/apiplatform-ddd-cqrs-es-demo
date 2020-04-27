<?php
declare(strict_types=1);

namespace App\Voucher\Domain\Command;

use App\Common\ValueObject\Price;
use App\Core\Domain\Command;
use App\User\Domain\Model\CustomerInterface;
use App\Voucher\Domain\Model\Type;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class CreateVoucher implements Command
{
    private CustomerInterface $customer;
    private Type $type;
    private ?UuidInterface $id;
    private ?DateTimeImmutable $startDate;
    private ?DateTimeImmutable $endDate;
    private ?int $maximumAmount;
    private ?Price $price;

    public function __construct(
        CustomerInterface $customer,
        Type $type,
        ?UuidInterface $id,
        ?DateTimeImmutable $startDate,
        ?DateTimeImmutable $endDate,
        ?int $maximumAmount,
        ?Price $price
    ) {
        $this->customer = $customer;
        $this->type = $type;
        $this->id = $id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->maximumAmount = $maximumAmount;
        $this->price = $price;
    }

    public function customer(): CustomerInterface
    {
        return $this->customer;
    }

    public function type(): Type
    {
        return $this->type;
    }

    public function id(): ?UuidInterface
    {
        return $this->id;
    }

    public function startDate(): ?DateTimeImmutable
    {
        return $this->startDate;
    }

    public function endDate(): ?DateTimeImmutable
    {
        return $this->endDate;
    }

    public function maximumAmount(): ?int
    {
        return $this->maximumAmount;
    }

    public function price(): ?Price
    {
        return $this->price;
    }
}
