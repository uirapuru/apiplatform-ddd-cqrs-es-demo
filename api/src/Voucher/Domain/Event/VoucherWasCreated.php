<?php
declare(strict_types=1);

namespace App\Voucher\Domain\Event;

use Ramsey\Uuid\UuidInterface;

class VoucherWasCreated
{
    protected UuidInterface $voucherId;

    public function __construct(UuidInterface $voucherId)
    {
        $this->voucherId = $voucherId;
    }
}
