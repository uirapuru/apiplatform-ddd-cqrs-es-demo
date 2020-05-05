<?php
declare(strict_types=1);

namespace App\Core\Domain\Handler;

use App\Core\Domain\Command\RejectPayment;
use App\Core\Domain\Event\PaymentWasRejected;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;

final class RejectPaymentHandler
{
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function __invoke(RejectPayment $payPayment)
    {
        $this->eventBus->dispatch(new PaymentWasRejected(
            Uuid::uuid4(),
            $payPayment->paymentId(),
        ));
    }
}
