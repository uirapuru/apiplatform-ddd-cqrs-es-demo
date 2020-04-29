<?php

namespace App\Voucher\Domain\Repository;

use App\Voucher\Domain\Model\Voucher;
use Ramsey\Uuid\UuidInterface;

interface VoucherRepositoryInterface
{
    public function add(Voucher $user) : void;

    public function find(UuidInterface $uuid) : ?Voucher;
}
