<?php
declare(strict_types=1);

namespace App\Core\Domain\Saga;

use App\Core\Domain\Event\OrderForVoucherPlaced;
use App\Order\Domain\Command\CreateOrder;
use App\Order\Domain\Model\Product\Product;
use App\Payment\Domain\Command\CreatePayment;
use App\Voucher\Domain\Command\CreateVoucher;
use App\Voucher\Domain\Model\Type;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\Registry;

final class VoucherProcessManager
{
    use HandlesDomainEvents, HasState;

    private MessageBusInterface $commandBus;
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $commandBus, MessageBusInterface $eventBus, Registry $workflowRegistry)
    {
        $this->commandBus = $commandBus;
        $this->eventBus = $eventBus;
        $this->workflow = $workflowRegistry->get($this);
    }

    public function handleThatOrderForVoucherPlaced(OrderForVoucherPlaced $orderForVoucherPlaced) : void
    {
        $orderId = Uuid::fromString($orderForVoucherPlaced->orderId());
        $customerId = Uuid::fromString($orderForVoucherPlaced->customerId());
        $voucherId = Uuid::fromString($orderForVoucherPlaced->voucherId());


        $this->commandBus->dispatch(new CreateOrder($orderId, $customerId, [
            Product::voucher($voucherId)
        ]));

        $this->commandBus->dispatch(new CreatePayment($orderId));

        $this->commandBus->dispatch(new CreateVoucher(
            $customerId,
            new Type($orderForVoucherPlaced->type()),
            $orderId,
            $orderForVoucherPlaced->startDate(),
            $orderForVoucherPlaced->endDate(),
            $orderForVoucherPlaced->entriesAmount(),
        ));

        $this->workflow->apply($this, 'place', $orderForVoucherPlaced->toArray());
    }
}
