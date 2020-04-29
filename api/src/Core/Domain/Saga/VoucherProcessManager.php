<?php
declare(strict_types=1);

namespace App\Core\Domain\Saga;

use App\Core\Domain\Event\OrderForVoucherPlaced;
use App\Order\Domain\Command\CreateOrder;
use App\Order\Domain\Model\Product\Product;
use App\Payment\Domain\Command\CreatePayment;
use App\Payment\Domain\Event\PaymentWasPaid;
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

        $this->workflow->apply($this, 'place_order', $orderForVoucherPlaced->toArray());
    }

    public function handleThatPaymentWasPaid(PaymentWasPaid $paymentWasPaid) : void
    {
        $this->commandBus->dispatch(new PayPayment($paymentId));

        $this->commandBus->dispatch(new FinishOrder($orderId));

        $this->commandBus->dispatch(new ActivateVoucher($voucherId));

        $this->workflow->apply($this, 'pay', $paymentWasPaid->toArray());
    }

    public function handleThatPaymentWasRejected(PaymentWasRejected $paymentWasPaid) : void
    {
        $this->commandBus->dispatch(new RejectPayment($paymentId));

        $this->commandBus->dispatch(new RejectOrder($orderId));

        $this->commandBus->dispatch(new CloseVoucher($voucherId));

        $this->workflow->apply($this, 'reject_payment', $paymentWasPaid->toArray());
    }
}
