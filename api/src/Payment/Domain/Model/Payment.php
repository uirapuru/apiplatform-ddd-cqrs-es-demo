<?php
declare(strict_types=1);

namespace App\Payment\Domain\Model;

use App\Common\Traits\Timestampable;
use App\Common\Traits\UuidTrait;
use App\Common\ValueObject\Price;
use App\Order\Domain\Model\Order;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

final class Payment
{
    use UuidTrait, Timestampable;

    private Order $order;
    private Status $status;
    private Type $type;
    private Price $amount;

    public function __construct(UuidInterface $id, Order $order)
    {
        $this->id = $id;
        $this->order = $order;
        $this->status = Status::WAITING();
    }

    public function order(): Order
    {
        return $this->order;
    }

    public function pay(Type $type, Price $amount) : void
    {
        Assert::eq($this->status, Status::WAITING(), "Payment is %s, can't modify it");

        $this->type = $type;
        $this->amount = $amount;
        $this->status = Status::DONE();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function status(): Status
    {
        return $this->status;
    }

    public function reject() : void
    {
        $this->status = Status::REJECTED();
        $this->updatedAt = new \DateTimeImmutable();
    }
}
