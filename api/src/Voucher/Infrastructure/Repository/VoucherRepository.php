<?php
declare(strict_types=1);

namespace App\Voucher\Infrastructure\Repository;

use App\Voucher\Domain\Model\Voucher;
use App\Voucher\Domain\Repository\VoucherRepositoryInterface;
use Doctrine\ORM\EntityRepository;

final class VoucherRepository extends EntityRepository implements VoucherRepositoryInterface
{
    public function add(Voucher $user): void
    {
        $this->_em->persist($user);
    }
}
