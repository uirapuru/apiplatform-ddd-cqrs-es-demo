<?php
declare(strict_types=1);

namespace App\Voucher\Infrastructure\Repository;

use App\User\Domain\Model\UserInterface;
use App\Voucher\Domain\Model\Voucher;
use App\Voucher\Domain\Repository\VoucherRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class VoucherRepository implements VoucherRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function find(UuidInterface $uuid): ?Voucher
    {
        return $this->em->getRepository(Voucher::class)->find($uuid);
    }

    public function add(Voucher $voucher): void
    {
        $this->em->persist($voucher);
    }

    public function findByMember(UserInterface $member) : iterable
    {
        return $this->findBy(["member" => $member]);
    }
}