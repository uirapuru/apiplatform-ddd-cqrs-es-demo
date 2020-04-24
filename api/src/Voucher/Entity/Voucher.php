<?php

namespace App\Voucher\Entity;

use App\Common\Traits\Timestampable;
use App\Common\Traits\UuidTrait;
use App\Common\ValueObject\Price;
use App\Entry\Entity\Entry;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class Voucher
{
    use UuidTrait, Timestampable;

    /**
     * @var DateTimeImmutable
     */
    private $startDate;

    /**
     * @var DateTimeImmutable
     */
    private $endDate;

    /**
     * @var integer
     */
    private $maximumAmount;

    /**
     * @var Price
     */
    private $price;

    /**
     * @var Entry[]
     */
    private $entries;

    /**
     * @var DateTimeImmutable $deletedAt
     */
    private $closedAt;

    public function __construct(UuidInterface $id, DateTimeImmutable $startDate, ?DateTimeImmutable $endDate, ?Price $price, ?int $maximumAmount, ?iterable $entries)
    {
        if($endDate) {
            Assert::lessThanEq($startDate->getTimestamp(), $endDate->getTimestamp());
        }

        $this->id = $id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->price = $price;
        $this->maximumAmount = $maximumAmount;
        $this->entries = $entries;

        $this->createdAt = new DateTimeImmutable("now");
        $this->updatedAt = new DateTimeImmutable("now");
    }

    public function addEntry(Entry $entry) : void
    {
        if($this->maximumAmount) {
            Assert::lessThan(count($this->entries), $this->maximumAmount);
        }

        $this->entries[] =  $entry;
    }
}
