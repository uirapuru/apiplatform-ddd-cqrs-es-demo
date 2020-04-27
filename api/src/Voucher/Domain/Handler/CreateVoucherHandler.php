<?php
declare(strict_types=1);

namespace App\Voucher\Domain\Handler;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\Voucher\Domain\Command\CreateVoucher;
use App\Voucher\Domain\Event\VoucherWasCreated;
use App\Voucher\Domain\Model\Voucher;
use App\Voucher\Domain\Repository\VoucherRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateVoucherHandler implements MessageHandlerInterface
{
    private VoucherRepositoryInterface $voucherRepository;
    private UserRepositoryInterface $userRepository;
    private MessageBusInterface $bus;

    public function __construct(VoucherRepositoryInterface $voucherRepository, UserRepositoryInterface $userRepository, MessageBusInterface $bus)
    {
        $this->voucherRepository = $voucherRepository;
        $this->userRepository = $userRepository;
        $this->bus = $bus;
    }

    public function __invoke(CreateVoucher $command) : void
    {
        $this->voucherRepository->add(Voucher::create(
            $command->id(),
            $command->customer(),
            $command->type(),
            $command->startDate(),
            $command->endDate(),
            $command->price(),
            $command->maximumAmount(),
        ));

//        $this->bus->dispatch(new VoucherWasCreated($command->id()));
    }
}
