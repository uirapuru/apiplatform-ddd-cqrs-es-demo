<?php
declare(strict_types=1);

namespace App\Order\Infrastructure\Repository;

use App\Order\Domain\Model\Order;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository implements OrderRepositoryInterface
{

    public function add(Order $order): void
    {
        // TODO: Implement add() method.
    }

    public function remove(Order $order): void
    {
        // TODO: Implement remove() method.
    }
}
