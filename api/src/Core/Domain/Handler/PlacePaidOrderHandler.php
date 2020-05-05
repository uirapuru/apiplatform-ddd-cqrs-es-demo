<?php
declare(strict_types=1);

namespace App\Core\Domain\Handler;

use App\Core\Domain\Command\PlacePaidOrderForVoucher;
use App\Core\Domain\Event\OrderForVoucherPlaced;
use App\Core\Domain\Event\PaymentWasPaid;
use App\Payment\Domain\Model\Type;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;

final class PlacePaidOrderHandler
{
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function __invoke(PlacePaidOrderForVoucher $command) : void
    {
        $price = $command->price();

        $this->eventBus->dispatch(new OrderForVoucherPlaced(
            $command->voucherId(),
            [
                "orderId"        => (string) $command->voucherId(),
                "voucherId"      => (string) $command->voucherId(),
                "customerId"     => (string) $command->customerId(),
                "type"           => $command->voucherType()->getValue(),
                "voucherType"    => $command->voucherType(),
                "startDate"      => $command->startDate(),
                "endDate"        => $command->endDate(),
                "entriesAmount"  => $command->entriesAmount(),
                "price"          => $price
            ]
        ));

        $this->eventBus->dispatch(new PaymentWasPaid(
            Uuid::uuid4(), $command->voucherId(), Type::CASH(), $price
        ));
    }
}
