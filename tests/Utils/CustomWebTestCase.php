<?php

namespace App\Tests\Utils;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomWebTestCase extends WebTestCase
{
    protected KernelBrowser $client;
    protected Registry $doctrine;

    public function setUp(): void
    {
        $this->client = static::createClient(['environment' => 'test', 'debug' => true]);
        $this->doctrine = static::getContainer()->get('doctrine');

        $this->userRepository = $this->doctrine->getRepository(User::class);
        $this->taskRepository = $this->doctrine->getRepository(Task::class);
    }

    protected function validConnection()
    {
        $this->client->request('GET', '/login');
        $this->client->submitForm('Se connecter', [
            '_username' => 'anonyme@gmail.com',
            '_password' => 'password',
        ]);
    }

    protected function adminValidConnection()
    {
        $this->client->request('GET', '/login');
        $this->client->submitForm('Se connecter', [
            '_username' => 'admin@gmail.com',
            '_password' => 'password',
        ]);
    }
}
