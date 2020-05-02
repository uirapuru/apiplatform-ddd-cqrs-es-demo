<?php
declare(strict_types=1);

namespace App\Payment\Domain\Command;

use App\Core\Domain\Command;
use Ramsey\Uuid\UuidInterface;

class CreatePayment implements Command
{
    private UuidInterface $orderId;
    private UuidInterface $paymentId;

    public function __construct(UuidInterface $orderId, UuidInterface $paymentId)
    {
        $this->orderId = $orderId;
        $this->paymentId = $paymentId;
    }

    public function orderId(): UuidInterface
    {
        return $this->orderId;
    }

    public function paymentId() : UuidInterface
    {
        return $this->paymentId;
    }
}
