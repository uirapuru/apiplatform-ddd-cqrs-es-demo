<?php
declare(strict_types=1);

namespace App\Voucher\Domain\Handler;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\Voucher\Domain\Model\Voucher;
use App\Voucher\Domain\Query\CurrentVoucher;
use App\Voucher\Domain\Repository\VoucherRepositoryInterface;
use DateTimeImmutable;

final class CurrentVoucherHandler
{
    private VoucherRepositoryInterface $voucherRepository;
    private DateTimeImmutable $now;
    private UserRepositoryInterface $userRepository;

    public function __construct(VoucherRepositoryInterface $voucherRepository, UserRepositoryInterface $userRepository, DateTimeImmutable $now = null)
    {
        $this->voucherRepository = $voucherRepository;
        $this->userRepository = $userRepository;
        $this->now = $now ?? new DateTimeImmutable("now");
    }

    public function __invoke(CurrentVoucher $currentVoucher) : iterable
    {
        $member = $this->userRepository->find($currentVoucher->memberId());

        $result = $this->voucherRepository->findByMember($member);

        $result = array_filter(
            $result,
            fn(Voucher $voucher): bool => $voucher->isActive() && $voucher->startDate() <= $this->now && $voucher->endDate() > $this->now
        );

        return $result;
    }
}
