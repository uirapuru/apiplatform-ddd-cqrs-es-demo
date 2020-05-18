<?php
declare(strict_types=1);

namespace App\Core\Domain\Saga;

use App\Common\Enum\EntryType;
use App\Core\Domain\Event\ActivityWasEntered;
use App\Core\Domain\Event\OrderForVoucherPlaced;
use App\Core\Infrastructure\Messenger\QueryBus;
use App\Core\Infrastructure\Storage\ProcessRepositoryInterface;
use App\Entry\Domain\Command\CreateEntry;
use App\Notification\Notifier;
use App\Notification\Type as NotificationType;
use App\Order\Domain\Command\CreateOrder;
use App\Order\Domain\Command\FinishOrder;
use App\Order\Domain\Command\RejectOrder;
use App\Order\Domain\Model\Product\Product;
use App\Order\Domain\Model\Product\VoucherProduct;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Payment\Domain\Command\CreatePayment;
use App\Payment\Domain\Command\PayPayment;
use App\Payment\Domain\Command\RejectPayment;
use App\Core\Domain\Event\PaymentWasPaid;
use App\Core\Domain\Event\PaymentWasRejected;
use App\Voucher\Domain\Command\ActivateVoucher;
use App\Voucher\Domain\Command\CreateVoucher;
use App\Voucher\Domain\Command\RejectVoucher;
use App\Voucher\Domain\Model\Type;
use App\Voucher\Domain\Query\CurrentVoucher;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\Registry;

final class EntryProcessManager implements ProcessManagerInterface
{
    use HandlesDomainEvents;

    private MessageBusInterface $commandBus;
    private MessageBusInterface $eventBus;
    private QueryBus $queryBus;
    private Notifier $notifier;
    private DateTimeImmutable $now;

    public function __construct(
        MessageBusInterface $commandBus,
        MessageBusInterface $eventBus,
        QueryBus $queryBusWrapper,
        Notifier $notifier,
        DateTimeImmutable $now
    ) {
        $this->commandBus = $commandBus;
        $this->eventBus = $eventBus;
        $this->queryBus = $queryBusWrapper;
        $this->notifier = $notifier;
        $this->now = $now;
    }

    public function handleThatActivityWasEntered(ActivityWasEntered $activityWasEntered) : void
    {
        $vouchers = $this->queryBus->dispatch(new CurrentVoucher($activityWasEntered->memberId()));

        if(count($vouchers) > 0) {
            $type = EntryType::VOUCHER();
            // @todo what if more active vouchers - search for activity assigned to voucher?
        } else {
            $type = EntryType::CREDIT();
        }

        $this->commandBus->dispatch(new CreateEntry(
            Uuid::uuid4(),
            $activityWasEntered->memberId(),
            $activityWasEntered->activityId(),
            $type,
            $this->now
        ));

        $this->notifier->notify('Entry created', NotificationType::SUCCESS());
    }

}
