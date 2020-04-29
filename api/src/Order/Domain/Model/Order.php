<?php

namespace App\Order\Domain\Model;

use App\Common\Traits\Timestampable;
use App\Common\Traits\UuidTrait;
use App\Common\ValueObject\Price;
use App\User\Domain\Model\CustomerInterface;
use Ramsey\Uuid\UuidInterface;

class Order
{
    use UuidTrait, Timestampable;
    private iterable $products;
    private CustomerInterface $customer;
    private Price $totalPrice;

    public function __construct(UuidInterface $id, iterable $products, CustomerInterface $customer)
    {
        $this->id = $id;
        $this->products = $products;
        $this->customer = $customer;
    }

    public function customer(): CustomerInterface
    {
        return $this->customer;
    }
}
