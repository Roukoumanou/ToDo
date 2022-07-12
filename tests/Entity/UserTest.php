<?php
namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function getUser(): User
    {
        return (new User())
            ->setUsername('Mon Nom Et Prénom')
            ->setEmail('email@gmail.com')
            ->setRoles(['ROLE_USER'])
            ->setPassword('password')
            ;
    }

    public function assertHasErrors(User $user, int $number = 0)
    {
        self::bootKernel(['environment' => 'test', 'debug' => true]);
        $errors = static::getContainer()->get('validator')->validate($user);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }

    public function testValidUser()
    {
        $this->assertHasErrors($this->getUser(), 0);
    }

    public function testUsernameNotBlank()
    {
        $this->assertHasErrors($this->getUser()->setUsername(''), 1);
    }

    public function testEmailNotBlank()
    {
        $this->assertHasErrors($this->getUser()->setEmail(''), 1);
    }

    public function testEmailInvalid()
    {
        $this->assertHasErrors($this->getUser()->setEmail('test@.com'), 1);
    }
}
