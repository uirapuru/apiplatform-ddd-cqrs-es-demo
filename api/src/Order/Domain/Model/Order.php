<?php

namespace App\Order\Domain\Model;

use App\Common\Traits\Timestampable;
use App\Common\Traits\UuidTrait;
use App\Common\ValueObject\Price;
use App\Payment\Domain\Model\Payment;
use App\User\Domain\Model\CustomerInterface;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

final class Order
{
    use UuidTrait, Timestampable;
    private iterable $products;
    private CustomerInterface $customer;
    private Price $totalPrice;
    private Status $status;
    private Payment $payment;

    public function __construct(UuidInterface $id, iterable $products, CustomerInterface $customer)
    {
        $this->id = $id;
        $this->products = $products;
        $this->customer = $customer;

        $this->status = Status::NEW();
    }

    public function customer(): CustomerInterface
    {
        return $this->customer;
    }

    public function markPaid() : void
    {
        $this->status = Status::PAID();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function markRejected() : void
    {
        $this->status = Status::REJECTED();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function status(): Status
    {
        return $this->status;
    }

    public function payment(): Payment
    {
        return $this->payment;
    }

    public function setPayment(Payment $payment): void
    {
        $this->payment = $payment;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function finish() : void
    {
        $this->status = Status::PAID();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function products(): iterable
    {
        return $this->products;
    }

    public function totalPrice(): Price
    {
        return $this->totalPrice;
    }
}
