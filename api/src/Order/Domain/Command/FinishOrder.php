<?php
declare(strict_types=1);

namespace App\Order\Domain\Command;

use App\Core\Domain\Command;
use Ramsey\Uuid\UuidInterface;

final class FinishOrder implements Command
{
    private UuidInterface $orderId;

    public function __construct(UuidInterface $orderId)
    {
        $this->orderId = $orderId;
    }

    public function orderId(): UuidInterface
    {
        return $this->orderId;
    }
}
