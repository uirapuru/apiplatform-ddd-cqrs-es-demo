<?php
declare(strict_types=1);

namespace App\Payment\Infrastructure\Repository;

use App\Payment\Domain\Repository\PaymentRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class PaymentRepository extends EntityRepository implements PaymentRepositoryInterface
{

}
