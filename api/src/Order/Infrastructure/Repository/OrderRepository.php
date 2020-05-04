<?php
declare(strict_types=1);

namespace App\Order\Infrastructure\Repository;

use App\Common\Traits\HasEntityManager;
use App\Order\Domain\Model\Order;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\User\Domain\Model\CustomerInterface;
use Ramsey\Uuid\UuidInterface;

class OrderRepository implements OrderRepositoryInterface
{
    use HasEntityManager;

    public function findByUser(CustomerInterface $user): iterable
    {
        // TODO: Implement findByUser() method.
    }

    public function find(UuidInterface $uuid): ?Order
    {
        // TODO: Implement find() method.
    }

    public function findByPaymentId(UuidInterface $paymentId): ?Order
    {
        // TODO: Implement findByPaymentId() method.
    }

    public function add(Order $order): void
    {
        // TODO: Implement add() method.
    }

    public function remove(Order $order): void
    {
        // TODO: Implement remove() method.
    }
}
