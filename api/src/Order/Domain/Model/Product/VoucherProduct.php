<?php
declare(strict_types=1);

namespace App\Order\Domain\Model\Product;

use Ramsey\Uuid\UuidInterface;

final class VoucherProduct extends Product implements OrderProductInterface
{
    private UuidInterface $voucherId;

    public function __construct(UuidInterface $voucherId)
    {
        $this->voucherId = $voucherId;
    }
}
