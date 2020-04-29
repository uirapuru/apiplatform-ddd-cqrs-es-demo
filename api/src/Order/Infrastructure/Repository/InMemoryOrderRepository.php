<?php
declare(strict_types=1);

namespace App\Order\Infrastructure\Repository;

use App\Order\Domain\Model\Order;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\User\Domain\Model\CustomerInterface;
use App\User\Domain\Model\UserInterface;
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

    public function find(UuidInterface $uuid): ?UserInterface
    {
        return $this->orders[$uuid->toString()] ?? null;
    }

    public function findByUser(CustomerInterface $user) : iterable
    {
        return array_filter($this->orders, fn(Order $order): bool => $user == $order->customer());
    }

    public function size(): int
    {
        return count($this->orders);
    }
}
