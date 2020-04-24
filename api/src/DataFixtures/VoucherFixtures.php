<?php

namespace App\DataFixtures;

use App\Voucher\Factory\VoucherFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VoucherFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=0; $i<5; $i++) {
            $voucher = VoucherFactory::create()->get();

            $this->addReference("voucher_".$i, $voucher);

            $manager->persist($voucher);
        }

        $manager->flush();
    }
}
