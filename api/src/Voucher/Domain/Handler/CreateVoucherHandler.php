<?php
declare(strict_types=1);

namespace App\Voucher\Domain\Handler;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\Voucher\Domain\Command\CreateVoucher;
use App\Voucher\Domain\Event\VoucherWasCreated;
use App\Voucher\Domain\Model\Voucher;
use App\Voucher\Domain\Repository\VoucherRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Webmozart\Assert\Assert;

final class CreateVoucherHandler implements MessageHandlerInterface
{
    private VoucherRepositoryInterface $voucherRepository;
    private UserRepositoryInterface $userRepository;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        VoucherRepositoryInterface $voucherRepository,
        UserRepositoryInterface $userRepository,
        EventDispatcherInterface $dispatcher
    ) {
        $this->voucherRepository = $voucherRepository;
        $this->userRepository = $userRepository;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(CreateVoucher $command) : void
    {
        $customer = $this->userRepository->find($command->customerId());

        Assert::notNull($customer);

        $this->voucherRepository->add(Voucher::create(
            $command->id(),
            $customer,
            $command->type(),
            $command->startDate(),
            $command->endDate(),
            $command->maximumAmount(),
        ));

//        $this->dispatcher->dispatch(new VoucherWasCreated($command->id()));
    }
}
