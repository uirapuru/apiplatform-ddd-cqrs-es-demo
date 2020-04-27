<?php

namespace App\Voucher\Domain\Repository;

use App\Voucher\Domain\Model\Voucher;

interface VoucherRepositoryInterface
{
    public function add(Voucher $user) : void;
}
