<?php
declare(strict_types=1);

namespace App\Payment\Domain\Command;

use App\Common\ValueObject\Price;
use App\Core\Domain\Command;
use App\Payment\Domain\Model\Type;
use Ramsey\Uuid\UuidInterface;

final class PayPayment implements Command
{
    private UuidInterface $paymentId;
    private Type $type;
    private Price $amount;

    public function __construct(UuidInterface $paymentId, Type $type, Price $amount)
    {
        $this->paymentId = $paymentId;
        $this->type = $type;
        $this->amount = $amount;
    }

    public function paymentId(): UuidInterface
    {
        return $this->paymentId;
    }

    public function type() : Type
    {
        return $this->type;
    }

    public function amount(): Price
    {
        return $this->amount;
    }
}
