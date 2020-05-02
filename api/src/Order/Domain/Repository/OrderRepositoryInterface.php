<?php
declare(strict_types=1);

namespace App\Order\Domain\Repository;

use App\Order\Domain\Model\Order;
use App\User\Domain\Model\CustomerInterface;
use App\User\Domain\Model\UserInterface;
use Ramsey\Uuid\UuidInterface;

interface OrderRepositoryInterface
{
    public function findByUser(CustomerInterface $user) : iterable;

    public function add(Order $order): void;

    public function find(UuidInterface $uuid): ?Order;

    public function remove(Order $order): void;

    public function findByPaymentId(UuidInterface $paymentId) : ?Order;
}
