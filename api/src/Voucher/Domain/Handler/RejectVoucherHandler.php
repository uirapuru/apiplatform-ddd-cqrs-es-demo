<?php
declare(strict_types=1);

namespace App\Voucher\Domain\Handler;

use App\Voucher\Domain\Command\ActivateVoucher;
use App\Voucher\Domain\Command\RejectVoucher;
use App\Voucher\Domain\Repository\VoucherRepositoryInterface;
use Webmozart\Assert\Assert;

final class RejectVoucherHandler
{
    private VoucherRepositoryInterface $voucherRepository;

    public function __construct(VoucherRepositoryInterface $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }

    public function __invoke(RejectVoucher $rejectVoucher) : void
    {
        $voucher = $this->voucherRepository->find($rejectVoucher->voucherId());

        Assert::notNull($voucher, "Voucher not found");

        $voucher->close();
    }
}
