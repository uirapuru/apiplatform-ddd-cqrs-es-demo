<?php
declare(strict_types=1);

namespace App\Core\Domain\Handler;

use App\Core\Domain\Command\PayPayment;
use App\Payment\Domain\Event\PaymentWasPaid;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;


final class PayPaymentHandler
{
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function __invoke(PayPayment $payPayment)
    {
        $this->eventBus->dispatch(new PaymentWasPaid(
            Uuid::uuid4(),
            $payPayment->paymentId(),
            $payPayment->type(),
            $payPayment->amount()
        ));
    }
}
