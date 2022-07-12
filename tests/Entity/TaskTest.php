<?php
namespace App\Tests\Entity;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{
    public function getTask(): Task
    {
        return (new Task())
            ->setId(1)
            ->setTitle("Un Titre")
            ->setContent("Un contenu de ouf !")
            ->setCreatedAt(new \DateTime())
            ;
    }

    public function assertHasErrors(Task $task, int $number = 0)
    {
        self::bootKernel(['environment' => 'test', 'debug' => true]);
        $errors = static::getContainer()->get('validator')->validate($task);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }

    public function testValidTask()
    {
        $this->assertHasErrors($this->getTask(), 0);
    }

    public function testTaskTitleNotBlank()
    {
        $this->assertHasErrors($this->getTask()->setTitle(''), 1);
    }

    public function testTaskContentNotBlank()
    {
        $this->assertHasErrors($this->getTask()->setContent(''), 1);
    }
}
