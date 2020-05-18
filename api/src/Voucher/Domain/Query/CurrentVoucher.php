<?php
declare(strict_types=1);

namespace App\Voucher\Domain\Query;

use Ramsey\Uuid\UuidInterface;

final class CurrentVoucher
{
    protected UuidInterface $memberId;

    public function __construct(UuidInterface $memberId)
    {
        $this->memberId = $memberId;
    }

    public function memberId(): UuidInterface
    {
        return $this->memberId;
    }
}
