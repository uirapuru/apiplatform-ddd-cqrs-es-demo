<?php

namespace App\Voucher\Domain\Repository;

use App\User\Domain\Model\UserInterface;
use App\Voucher\Domain\Model\Voucher;
use Ramsey\Uuid\UuidInterface;

interface VoucherRepositoryInterface
{
    public function add(Voucher $voucher) : void;

    public function find(UuidInterface $uuid) : ?Voucher;

    public function findByMember(UserInterface $member) : iterable;
}
