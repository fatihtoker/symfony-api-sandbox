<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $roleRepo = $manager->getRepository(Role::class);
        $adminRole = $roleRepo->findOneBy(['name' => 'admin']);

        $userAdmin = new User();
        $userAdmin->setEmail('admin@admin.com');
        $passwordAdmin = $this->encoder->encodePassword($userAdmin, 'admin');
        $userAdmin->setPassword($passwordAdmin);
        $userAdmin->addRole($adminRole);
        $manager->persist($userAdmin);

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@user.com');
            $passwordUser = $this->encoder->encodePassword($user, 'user');
            $user->setPassword($passwordUser);
            $manager->persist($user);
        }

        $manager->flush();
    }
}