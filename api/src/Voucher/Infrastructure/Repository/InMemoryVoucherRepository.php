<?php
declare(strict_types=1);

namespace App\Voucher\Infrastructure\Repository;

use App\Voucher\Domain\Model\Voucher;
use App\Voucher\Domain\Repository\VoucherRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class InMemoryVoucherRepository implements VoucherRepositoryInterface
{
    private $vouchers = [];

    public function add(Voucher $user): void
    {
        $this->vouchers[$user->id()->toString()] = $user;
    }

    public function remove(Voucher $voucher): void
    {
        unset($this->vouchers[$voucher->id()->toString()]);
    }

    public function findById(UuidInterface $uuid): ?Voucher
    {
        if (isset($this->vouchers[$uuid->toString()])) {
            return $this->vouchers[$uuid->toString()];
        }

        return null;
    }

    public function size(): int
    {
        return count($this->vouchers);
    }
}
