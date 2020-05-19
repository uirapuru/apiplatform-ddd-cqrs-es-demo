<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Context\Transform;

use App\Voucher\Domain\Model\Type;
use Behat\Behat\Context\Context;

final class VoucherContext implements Context
{
    /**
     * @Transform :voucherType
     */
    public function voucherType(string $voucherType) : ?Type
    {
        return new Type($voucherType);
    }
}
