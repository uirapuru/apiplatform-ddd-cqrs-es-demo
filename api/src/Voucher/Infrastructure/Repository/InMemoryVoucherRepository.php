<?php
declare(strict_types=1);

namespace App\Voucher\Infrastructure\Repository;

use App\Voucher\Domain\Model\Voucher;
use App\Voucher\Domain\Repository\VoucherRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class InMemoryVoucherRepository implements VoucherRepositoryInterface
{
    private array $vouchers = [];

    public function add(Voucher $voucher): void
    {
        $this->vouchers[$voucher->id()->toString()] = $voucher;
    }

    public function remove(Voucher $voucher): void
    {
        unset($this->vouchers[$voucher->id()->toString()]);
    }

    public function find(UuidInterface $uuid): ?Voucher
    {
        return $this->vouchers[$uuid->toString()] ?? null;
    }

    public function size(): int
    {
        return count($this->vouchers);
    }
}
