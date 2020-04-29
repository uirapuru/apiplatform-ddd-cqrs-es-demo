<?php
declare(strict_types=1);

namespace App\Payment\Domain\Handler;

use App\Payment\Domain\Command\CreatePayment;

final class CreatePaymentHandler
{
    public function __invoke(CreatePayment $createPayment) : void
    {
        // TODO: Implement __invoke() method.
    }
}
