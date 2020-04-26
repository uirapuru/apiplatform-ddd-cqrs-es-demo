<?php

namespace App\DataFixtures;

use App\User\Entity\Admin;
use App\User\Entity\Instructor;
use App\User\Entity\Manager;
use App\User\Entity\Member;
use App\User\Entity\ParentUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $admin = new Admin();
        $this->addReference("admin", $admin);
        $manager->persist($admin);

        for($i=0; $i<5; $i++) {
            $instructor = new Instructor();
            $this->addReference("instructor".$i, $instructor);
            $manager->persist($instructor);
        }

        $managerUser = new Manager([
            $this->getReference("instructor0"),
            $this->getReference("instructor1"),
            $this->getReference("instructor2"),
            $this->getReference("instructor3"),
            $this->getReference("instructor4"),
        ]);

        $this->addReference("manager", $managerUser);
        $manager->persist($managerUser);

        for($i=0; $i<20; $i++) {
            $member = new Member();
            $this->addReference("member".$i, $member);
            $manager->persist($member);
        }

        $parent = new ParentUser([
            $this->getReference("member18"),
            $this->getReference("member19"),
        ]);

        $this->addReference("parent".$i, $parent);
        $manager->persist($parent);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['default'];
    }

}
