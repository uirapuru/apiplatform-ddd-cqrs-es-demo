<?php
declare(strict_types=1);

namespace App\Order\Domain\Handler;

use App\Order\Domain\Command\PlaceOrderForVoucher;
use App\Core\Domain\Event\OrderForVoucherPlaced;
use Symfony\Component\Messenger\MessageBusInterface;

final class PlaceOrderHandler
{
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function __invoke(PlaceOrderForVoucher $command) : void
    {
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
            ]
        ));
    }
}
