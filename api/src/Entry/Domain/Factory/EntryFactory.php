<?php

namespace App\Entry\Domain\Factory;

use App\Common\Enum\EntryType;
use App\Common\ValueObject\Price;
use App\Entry\Domain\Model\Entry;
use App\Voucher\Domain\Model\Voucher;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class EntryFactory
{
    private UuidInterface $id;
    private DateTimeImmutable $startDate;
    private DateTimeImmutable $endDate;
    private Price $price;
    private EntryType $type;
    private Voucher $voucher;

    public static function create() : self
    {
        $self = new self();

        $self->id = Uuid::uuid4();
        $self->startDate = new DateTimeImmutable("now");
        $self->endDate = new DateTimeImmutable("+45 minutes");
        $self->type = EntryType::VOUCHER();

        return $self;
    }

    public function withId(UuidInterface $id) : self
    {
        $this->id = $id;

        return $this;
    }

    public function withVoucher(Voucher $voucher) : self
    {
        $this->voucher = $voucher;

        return $this;
    }

    public function get() : Entry
    {
        return new Entry(
            $this->id,
            $this->startDate,
            $this->endDate,
            $this->type,
            $this->price,
            $this->voucher,
            null
        );
    }
}
