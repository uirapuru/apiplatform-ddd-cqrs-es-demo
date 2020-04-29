<?php
declare(strict_types=1);

namespace App\Payment\Domain\Repository;

use App\User\Domain\Model\CustomerInterface;

interface PaymentRepositoryInterface
{
    public function findByUser(CustomerInterface $user);
}
