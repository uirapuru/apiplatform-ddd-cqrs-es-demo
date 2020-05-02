<?php
declare(strict_types=1);

namespace App\Order\Infrastructure\Repository;

use App\Order\Domain\Model\Order;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\User\Domain\Model\CustomerInterface;
use Ramsey\Uuid\UuidInterface;

class InMemoryOrderRepository implements OrderRepositoryInterface
{
    private array $orders = [];

    public function add(Order $order): void
    {
        $this->orders[$order->id()->toString()] = $order;
    }

    public function remove(Order $order): void
    {
        unset($this->orders[$order->id()->toString()]);
    }

    public function find(UuidInterface $uuid): ?Order
    {
        return $this->orders[$uuid->toString()] ?? null;
    }

    public function findByUser(CustomerInterface $user) : iterable
    {
        return array_filter($this->orders, fn(Order $order): bool => $user == $order->customer());
    }

    public function findByPaymentId(UuidInterface $paymentId): ?Order
    {
        $collection = array_filter($this->orders, fn(Order $order): bool => $paymentId == $order->payment()->id());

        return array_pop($collection);
    }

    public function size(): int
    {
        return count($this->orders);
    }
}
