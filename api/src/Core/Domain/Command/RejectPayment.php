<?php
declare(strict_types=1);

namespace App\Core\Domain\Command;

use Ramsey\Uuid\UuidInterface;

final class RejectPayment
{
    private UuidInterface $paymentId;

    public function __construct(UuidInterface $paymentId)
    {
        $this->paymentId = $paymentId;
    }

    public function paymentId(): UuidInterface
    {
        return $this->paymentId;
    }
}
