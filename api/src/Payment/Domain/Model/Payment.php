<?php
declare(strict_types=1);

namespace App\Payment\Domain\Model;

use App\Common\Traits\Timestampable;
use App\Common\Traits\UuidTrait;
use App\Order\Domain\Model\Order;
use Ramsey\Uuid\UuidInterface;

final class Payment
{
    use UuidTrait, Timestampable;
    private Order $order;

    public function __construct(UuidInterface $id, Order $order)
    {
        $this->id = $id;
        $this->order = $order;
    }

    public function order(): Order
    {
        return $this->order;
    }
}
