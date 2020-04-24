<?php

namespace App\Entry\Entity;

use App\Common\Enum\EntryType;
use App\Common\Traits\Timestampable;
use App\Common\Traits\UuidTrait;
use App\Common\ValueObject\Price;
use App\Voucher\Entity\Voucher;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class Entry
{
    use UuidTrait, Timestampable;

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

    public function __construct(UuidInterface $id, DateTimeImmutable $startDate, DateTimeImmutable $endDate, EntryType $type, ?Price $price, ?Voucher $voucher)
    {
        $this->id = $id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->price = $price;
        $this->type = $type;

        if($type->equals(EntryType::PAID())) {
            Assert::notNull($price);
        }

        if($type->equals(EntryType::VOUCHER())) {
            Assert::notNull($voucher);
        }

        $this->voucher = $voucher;

        $this->createdAt = new DateTimeImmutable("now");
        $this->updatedAt = new DateTimeImmutable("now");
    }
}

