<?php
declare(strict_types=1);

namespace App\Payment\Domain\Handler;

use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Payment\Domain\Command\CreatePayment;
use App\Payment\Domain\Command\PayPayment;
use App\Payment\Domain\Model\Payment;
use App\Payment\Domain\Repository\PaymentRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

final class PayPaymentHandler
{
    private PaymentRepositoryInterface $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function __invoke(PayPayment $payPayment) : void
    {
        /** @var Payment $payment */
        $payment = $this->paymentRepository->find($payPayment->paymentId());

        Assert::notNull($payment, 'Payment does not exist');

        $payment->pay($payPayment->type(), $payPayment->amount());

//        $this->eventBus->dispatch(new PaymentWasCreated());
    }
}
