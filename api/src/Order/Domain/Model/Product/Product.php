<?php
declare(strict_types=1);

namespace App\Order\Domain\Model\Product;

use Ramsey\Uuid\UuidInterface;

abstract class Product
{
    public static function voucher(UuidInterface $id) : VoucherProduct
    {
        return new VoucherProduct($id);
    }
}
