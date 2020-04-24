<?php

namespace App\Entry\Factory;

use App\Common\Enum\EntryType;
use App\Common\ValueObject\Price;
use App\Entry\Entity\Entry;
use App\Voucher\Entity\Voucher;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class EntryFactory
{
    /**
     * @var UuidInterface
     */
    private $id;


    /**
     * @var DateTimeImmutable
     */
    protected $startDate;

    /**
     * @var DateTimeImmutable
     */
    protected $endDate;

    /**
     * @var Price $price
     */
    protected $price;

    /**
     * @var EntryType
     */
    protected $type;

    /**
     * @var Voucher
     */
    protected $voucher;

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
            $this->voucher
        );
    }
}
