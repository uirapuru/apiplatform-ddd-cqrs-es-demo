<?php
declare(strict_types=1);

namespace App\Payment\Infrastructure\Repository;

use App\Common\Traits\HasEntityManager;
use App\Payment\Domain\Repository\PaymentRepositoryInterface;
use App\User\Domain\Model\CustomerInterface;

final class PaymentRepository implements PaymentRepositoryInterface
{
    use HasEntityManager;

    public function findByUser(CustomerInterface $user)
    {
        // TODO: Implement findByUser() method.
    }
}
