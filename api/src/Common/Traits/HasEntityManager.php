<?php
declare(strict_types=1);

namespace App\Common\Traits;

use Doctrine\ORM\EntityManagerInterface;

trait HasEntityManager
{
    private EntityManagerInterface $_em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->_em = $em;
    }
}
