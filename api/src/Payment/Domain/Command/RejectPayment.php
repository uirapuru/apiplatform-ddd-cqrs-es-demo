<?php
declare(strict_types=1);

namespace App\Payment\Domain\Command;

use App\Common\ValueObject\Price;
use App\Core\Domain\Command;
use App\Payment\Domain\Model\Type;
use Ramsey\Uuid\UuidInterface;

final class RejectPayment implements Command
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
