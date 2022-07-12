<?php
namespace App\Tests\Controller;

use App\Tests\Utils\CustomWebTestCase;

class TaskControllerTest extends CustomWebTestCase
{
    public function testTaskListNotAuthorizedForAdmin()
    {
        $this->adminValidConnection();
        $this->client->request('GET', '/users/tasks');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testTaskListNotAuthorized()
    {
        $crawler = $this->client->request('GET', '/users/tasks');
        $this->assertResponseRedirects();
    }

    public function testTaskListAuthorizedForUser()
    {
        $this->validConnection();
        $tasks = $this->taskRepository->findAll();
        $taskNumber = count($tasks);

        $crawler = $this->client->request('GET', 'users/tasks');
        $this->assertResponseIsSuccessful();
        $this->assertCount(1, $crawler->filter('h1'));
        $this->assertCount($taskNumber, $tasks);
    }

    private function getTaskFormData()
    {
        $this->client->submitForm('Envoyer', [
            'task[title]' => 'roukoumanouamidou@gmail.com',
            'task[content]' => 'password',
        ]);
    }

    public function testTaskCreate()
    {
        $this->validConnection();
        $crawler = $this->client->request('GET', '/users/tasks/create');
        $this->getTaskFormData();
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertCount(1, $crawler->filter('h1'));
    }

    public function testTaskEdit()
    {
        $this->validConnection();
        $crawler = $this->client->request('GET', '/users/tasks/1/edit');
        
        $this->getTaskFormData();
        $this->client->followRedirect();
        $this->assertSelectorExists('div[class*="alert alert-success"]');
        $this->assertCount(1, $crawler->filter('h1'));
    }

    public function testToggleTask()
    {
        $this->validConnection();
        $this->client->request('GET', '/users/tasks/1/toggle');
        $this->client->followRedirect();
        $this->assertSelectorExists('div[class*="alert alert-success"]');
    }

    public function testTasksDone()
    {
        $this->validConnection();
        $crawler = $this->client->request('GET', '/users/tasks-done');
        $this->assertCount(1, $crawler->filter('h1'));
    }

    public function testTaskDelete()
    {
        $this->validConnection();
        $this->client->request('GET', '/users/tasks/2/delete');
        
        $this->client->followRedirect();
        $this->assertSelectorExists('div[class*="alert alert-success"]');
    }
}
