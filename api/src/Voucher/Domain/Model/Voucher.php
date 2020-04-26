<?php

namespace App\Voucher\Domain\Model;

use App\Common\Traits\Timestampable;
use App\Common\Traits\UuidTrait;
use App\Common\ValueObject\Price;
use App\Entry\Entity\Entry;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class Voucher
{
    use UuidTrait, Timestampable;

    private ?DateTimeImmutable $startDate;

    private ?DateTimeImmutable $endDate;

    private ?int $maximumAmount;

    private ?Price $price;

    /**
     * @var Entry[]
     */
    private iterable $entries = [];

    private DateTimeImmutable $closedAt;

    public function __construct(UuidInterface $id, ?DateTimeImmutable $startDate, ?DateTimeImmutable $endDate, ?Price $price, ?int $maximumAmount, iterable $entries = [])
    {
        if($endDate && $startDate) {
            Assert::lessThanEq($startDate->getTimestamp(), $endDate->getTimestamp());
        }

        $this->id = $id ?? Uuid::uuid4();
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
