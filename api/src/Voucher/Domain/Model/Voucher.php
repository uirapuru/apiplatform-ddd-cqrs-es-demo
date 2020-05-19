<?php

namespace App\Voucher\Domain\Model;

use App\Common\Traits\Timestampable;
use App\Common\Traits\UuidTrait;
use App\Entry\Domain\Model\Entry;
use App\User\Domain\Model\CustomerInterface;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

final class Voucher
{
    use UuidTrait, Timestampable;
    private CustomerInterface $member;
    private ?DateTimeImmutable $startDate;
    private ?DateTimeImmutable $endDate;
    private ?int $maximumAmount;
    private ?DateTimeImmutable $closedAt = null;
    private Type $type;
    /**
     * @var Entry[]
     */
    private iterable $entries = [];
    private bool $active;

    public function __construct(
        ?UuidInterface $id,
        CustomerInterface $member,
        Type $type,
        ?DateTimeImmutable $startDate,
        ?DateTimeImmutable $endDate,
        ?int $maximumAmount,
        iterable $entries = []
    ) {
        if($endDate && $startDate) {
            Assert::lessThanEq($startDate->getTimestamp(), $endDate->getTimestamp());
        }

        $this->id = $id ?? Uuid::uuid4();
        $this->type = $type;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->maximumAmount = $maximumAmount;
        $this->entries = $entries;
        $this->member = $member;
        $this->active = false;

        $this->createdAt = new DateTimeImmutable("now");
        $this->updatedAt = new DateTimeImmutable("now");
    }

    public static function create(
        ?UuidInterface $id,
        CustomerInterface $member,
        Type $type,
        ?DateTimeImmutable $startDate,
        ?DateTimeImmutable $endDate,
        ?int $maximumAmount
    ) : self
    {
        return new self(
            $id, $member, $type, $startDate, $endDate, $maximumAmount
        );
    }

    public function addEntry(Entry $entry) : void
    {
        if($this->maximumAmount) {
            Assert::lessThan(count($this->entries), $this->maximumAmount);
        }

        $this->entries[] =  $entry;
    }

    public function isActive() : bool
    {
        return $this->active;
    }

    public function activate() : void
    {
        $this->active = true;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function isClosed() : bool
    {
        return false === is_null($this->closedAt);
    }

    public function close() : void
    {
        $this->closedAt = new DateTimeImmutable();
    }

    public function startDate(): ?DateTimeImmutable
    {
        return $this->startDate;
    }

    public function endDate(): ?DateTimeImmutable
    {
        return $this->endDate;
    }

    public function member(): CustomerInterface
    {
        return $this->member;
    }
}