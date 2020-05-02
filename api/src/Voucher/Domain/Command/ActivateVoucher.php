<?php
declare(strict_types=1);

namespace App\Voucher\Domain\Command;

use App\Core\Domain\Command;
use Ramsey\Uuid\UuidInterface;

final class ActivateVoucher implements Command
{
    private UuidInterface $voucherId;

    public function __construct(UuidInterface $voucherId)
    {
        $this->voucherId = $voucherId;
    }

    public function voucherId(): UuidInterface
    {
        return $this->voucherId;
    }
}
