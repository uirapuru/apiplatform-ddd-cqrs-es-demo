<?php
declare(strict_types=1);

namespace App\Payment\Domain\Handler;

use App\Payment\Domain\Command\RejectPayment;
use App\Payment\Domain\Model\Payment;
use App\Payment\Domain\Repository\PaymentRepositoryInterface;
use Webmozart\Assert\Assert;

final class RejectPaymentHandler
{
    private PaymentRepositoryInterface $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function __invoke(RejectPayment $payPayment) : void
    {
        /** @var Payment $payment */
        $payment = $this->paymentRepository->find($payPayment->paymentId());

        Assert::notNull($payment, 'Payment does not exist');

        $payment->reject();

//        $this->eventBus->dispatch(new PaymentWasCreated());
    }
}
