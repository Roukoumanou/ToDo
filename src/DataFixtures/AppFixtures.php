<?php

namespace App\DataFixtures;

use App\Entity\Task;
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
                ->setEmail("admin@gmail.com")
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($this->hasher->hashPassword($admin, "password"));

        $manager->persist($admin);

        $user = new User();
            $user->setUsername("Anonyme User")
            ->setEmail("anonyme@gmail.com")
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->hasher->hashPassword($user, "password"));

        $manager->persist($user);

        for ($i=1; $i < 50; $i++) { 
            $task = new Task();
                $task->setTitle('Tâche N°'.$i)
                    ->setContent('Ceci est le contenu de la tâche N°'.$i)
                    ->setUser($admin)
                    ->setCreatedAt(new \DateTime());

            $manager->persist($task);
        }

        $manager->flush();
    }
}
