<?php
declare(strict_types=1);

namespace App\Order\Domain\Handler;

use App\Order\Domain\Command\FinishOrder;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use Webmozart\Assert\Assert;

final class FinishOrderHandler
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function __invoke(FinishOrder $finishOrder) : void
    {
        $order = $this->orderRepository->find($finishOrder->orderId());

        Assert::notNull($order, "Order not found");

        $order->finish();
    }
}
