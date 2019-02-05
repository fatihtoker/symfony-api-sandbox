<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $adminRole = new Role();
        $adminRole->setName('admin');
        $adminRole->setDisplayName('Sistem Yöneticisi');

        $manager->persist($adminRole);

        $manager->flush();
    }
}