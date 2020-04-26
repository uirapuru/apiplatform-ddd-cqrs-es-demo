<?php

namespace App\Voucher\Domain\Factory;

use App\Common\ValueObject\Price;
use App\Entry\Entity\Entry;
use App\Voucher\Domain\Model\Voucher;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class VoucherFactory
{
    private UuidInterface $id;

    private ?DateTimeImmutable $startDate;

    private ?DateTimeImmutable $endDate;

    private ?int $maximumAmount;

    private Price $price;

    /**
     * @var Entry[]
     */
    private iterable $entries;

    public static function create() : self
    {
        $self = new self();

        $self->id = Uuid::uuid4();
        $self->startDate = new DateTimeImmutable("now");
        $self->endDate = new DateTimeImmutable("+1 month");

        return $self;
    }

    public function withId(UuidInterface $id) : self
    {
        $this->id = $id;

        return $this;
    }

    public function get() : Voucher
    {
        return new Voucher(
            $this->id,
            $this->startDate,
            $this->endDate,
            $this->price,
            $this->maximumAmount,
            $this->entries
        );
    }
}
