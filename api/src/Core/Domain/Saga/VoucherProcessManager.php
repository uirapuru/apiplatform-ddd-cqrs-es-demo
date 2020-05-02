<?php
declare(strict_types=1);

namespace App\Core\Domain\Saga;

use App\Core\Domain\Event\OrderForVoucherPlaced;
use App\Core\Infrastructure\Storage\ProcessRepositoryInterface;
use App\Order\Domain\Command\CreateOrder;
use App\Order\Domain\Command\FinishOrder;
use App\Order\Domain\Model\Product\Product;
use App\Order\Domain\Model\Product\VoucherProduct;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Payment\Domain\Command\CreatePayment;
use App\Payment\Domain\Command\PayPayment;
use App\Payment\Domain\Event\PaymentWasPaid;
use App\Voucher\Domain\Command\ActivateVoucher;
use App\Voucher\Domain\Command\CreateVoucher;
use App\Voucher\Domain\Model\Type;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\Registry;

final class VoucherProcessManager implements ProcessManagerInterface
{
    private UuidInterface $processId;

    use HandlesDomainEvents, HasState;

    private MessageBusInterface $commandBus;
    private MessageBusInterface $eventBus;
    private OrderRepositoryInterface $orderRepository;
    private ProcessRepositoryInterface $processRepository;

    public function __construct(MessageBusInterface $commandBus, MessageBusInterface $eventBus, Registry $workflowRegistry, OrderRepositoryInterface $orderRepository, ProcessRepositoryInterface $processRepository)
    {
        $this->commandBus = $commandBus;
        $this->eventBus = $eventBus;
        $this->orderRepository = $orderRepository;
        $this->processRepository = $processRepository;

        $this->workflow = $workflowRegistry->get($this);
    }

    public function processId(): UuidInterface
    {
        return $this->processId;
    }

    public function handleThatOrderForVoucherPlaced(OrderForVoucherPlaced $orderForVoucherPlaced) : void
    {
        $orderId = Uuid::fromString($orderForVoucherPlaced->orderId());
        $customerId = Uuid::fromString($orderForVoucherPlaced->customerId());
        $voucherId = Uuid::fromString($orderForVoucherPlaced->voucherId());

        $this->processId = $orderId;

        $this->commandBus->dispatch(new CreateOrder($orderId, $customerId, [
            Product::voucher($voucherId)
        ]));

        $this->commandBus->dispatch(new CreatePayment($orderId, $orderId));

        $this->commandBus->dispatch(new CreateVoucher(
            $customerId,
            new Type($orderForVoucherPlaced->type()),
            $orderId,
            $orderForVoucherPlaced->startDate(),
            $orderForVoucherPlaced->endDate(),
            $orderForVoucherPlaced->entriesAmount(),
        ));

        $this->workflow->apply($this, 'place_order', $orderForVoucherPlaced->toArray());

        $this->processRepository->add($this);
    }

    public function handleThatPaymentWasPaid(PaymentWasPaid $paymentWasPaid) : void
    {
        $paymentId = $paymentWasPaid->paymentId();

        $order = $this->orderRepository->findByPaymentId($paymentId);

        $vouchers = array_map(fn(VoucherProduct $voucherProduct) : UuidInterface => $voucherProduct->id(),
            array_filter($order->products(), fn(Product $product) : bool => $product instanceof VoucherProduct)
        );

        $this->commandBus->dispatch(new PayPayment($paymentId, $paymentWasPaid->type(), $paymentWasPaid->amount()));

        $this->commandBus->dispatch(new FinishOrder($order->id()));

        foreach($vouchers as $voucherId) {
            $this->commandBus->dispatch(new ActivateVoucher($voucherId));
        }

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
