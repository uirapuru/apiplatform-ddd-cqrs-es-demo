<?php
declare(strict_types=1);

namespace App\Payment\Domain\Handler;

use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Payment\Domain\Command\CreatePayment;
use App\Payment\Domain\Model\Payment;
use App\Payment\Domain\Repository\PaymentRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

final class CreatePaymentHandler
{
    private OrderRepositoryInterface $orderRepository;
    private PaymentRepositoryInterface $paymentRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, PaymentRepositoryInterface $paymentRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->paymentRepository = $paymentRepository;
    }

    public function __invoke(CreatePayment $createPayment) : void
    {
        $order = $this->orderRepository->find($createPayment->orderId());

        Assert::notNull($order);

        $payment = new Payment($createPayment->paymentId(), $order);

        $order->setPayment($payment);

        $this->paymentRepository->add($payment);

//        $this->eventBud->dispatch(new PaymentWasCreated());
    }
}
