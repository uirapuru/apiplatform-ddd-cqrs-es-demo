<?php

namespace App\DataFixtures;

use App\Entry\Factory\EntryFactory;
use App\Voucher\Entity\Voucher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class EntryFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i=0; $i<5; $i++) {
            /** @var Voucher $voucher */
            $voucher = $this->getReference("voucher_".$i);

            for($j=0; $j<5; $j++) {

                $entry = EntryFactory::create()
                    ->withVoucher($voucher)
                    ->get();

                $voucher->addEntry($entry);

                $this->addReference("entry_" . ($i * 10 + $j), $entry);

                $manager->persist($entry);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            VoucherFixtures::class
        ];
    }

    public static function getGroups(): array
    {
        return ['default'];
    }

}
