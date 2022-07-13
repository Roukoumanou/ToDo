<?php
namespace App\Service\DomainCode;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Interface\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService implements UserInterface
{
    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $hasher;
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $hasher, UserRepository $userRepository)
    {
        $this->em = $em;
        $this->hasher = $hasher;
        $this->userRepository = $userRepository;
    }
    
    /**
     * Retourne Users[]|null
     *
     * @return array|null
     */
    public function listUser(): ?array
    {
        return $this->userRepository->findAll();
    }

    public function createUser(User $user): User
    {
        $password = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);
        
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function userEdit(User $user): void
    {
        $password = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);
        
        $this->em->flush();
    }
}
