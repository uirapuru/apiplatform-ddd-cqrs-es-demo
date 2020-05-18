<?php

namespace App\Entry\Domain\Model;

use App\Common\Enum\EntryType;
use App\Common\Traits\Timestampable;
use App\Common\Traits\UuidTrait;
use App\Common\ValueObject\Price;
use App\Voucher\Domain\Model\Voucher;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class Entry
{
    use UuidTrait, Timestampable;

    protected DateTimeImmutable $startDate;

    protected DateTimeImmutable $endDate;

    protected EntryType $type;

    public function __construct(UuidInterface $id, DateTimeImmutable $startDate, EntryType $type, ?DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->startDate = $startDate;
        $this->type = $type;

        $this->createdAt = $createdAt ?? new DateTimeImmutable("now");
        $this->updatedAt = $createdAt ?? new DateTimeImmutable("now");
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function startDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function endDate(): DateTimeImmutable
    {
        return $this->endDate;
    }

    public function type(): EntryType
    {
        return $this->type;
    }
}

