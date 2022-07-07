<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
            $admin->setUsername("Amidou Abdou Roukoumanou")
                ->setEmail("roukoumanouamidou@gmail.com")
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($this->hasher->hashPassword($admin, "password"));

        $manager->persist($admin);
        $manager->flush();
    }
}
