<?php

namespace App\Payment\Domain\Model;

use App\Common\Traits\Timestampable;
use App\Common\Traits\UuidTrait;
use App\Common\ValueObject\Price;
use App\User\Domain\Model\CustomerInterface;

class Payment
{
    use UuidTrait, Timestampable;
    private iterable $products;
    private CustomerInterface $customer;
    private Price $totalPrice;

    public function __construct(iterable $products, CustomerInterface $customer)
    {
        $this->products = $products;
        $this->customer = $customer;

//        $this->calculateTotalPrice();
    }
}
