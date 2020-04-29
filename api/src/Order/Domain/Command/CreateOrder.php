<?php
declare(strict_types=1);

namespace App\Order\Domain\Command;

use App\Core\Domain\Command;
use Ramsey\Uuid\UuidInterface;

final class CreateOrder implements Command
{
    private UuidInterface $orderId;
    private UuidInterface $customerId;
    private iterable $products;

    public function __construct(UuidInterface $orderId, UuidInterface $customerId, iterable $products)
    {
        $this->orderId = $orderId;
        $this->customerId = $customerId;
        $this->products = $products;
    }

    public function orderId(): UuidInterface
    {
        return $this->orderId;
    }

    public function customerId(): UuidInterface
    {
        return $this->customerId;
    }

    public function products(): iterable
    {
        return $this->products;
    }
}
