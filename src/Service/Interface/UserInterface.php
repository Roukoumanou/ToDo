<?php
namespace App\Service\Interface;

use App\Entity\User;

interface UserInterface
{
    public function listUser(): ?array;

    public function createUser(User $user): User;

    public function userEdit(User $user): void;
}
