<?php
declare(strict_types=1);

namespace App\Payment\Domain\Repository;

use Doctrine\ORM\EntityRepository;

class PaymentRepository extends EntityRepository implements PaymentRepositoryInterface
{

}
