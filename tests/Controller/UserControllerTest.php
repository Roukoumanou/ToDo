<?php
namespace App\Tests\Controller;

use App\Tests\Utils\CustomWebTestCase;

class UserControllerTest extends CustomWebTestCase
{
    public function testListUser()
    {
        $this->adminValidConnection();

        $users = $this->userRepository->findAll();

        $crawler = $this->client->request('GET', '/admin/users');
        $this->assertResponseIsSuccessful();
        $this->assertCount(1, $crawler->filter('h1'));
        $this->assertCount(2, $users);
    }

    public function testListUserForbiden()
    {
        $this->client->request('GET', '/admin/users');
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testUserCreateSuccess()
    {
        $this->adminValidConnection();

        $crawler = $this->client->request('GET', '/admin/users/create');
        $this->assertResponseIsSuccessful();
        $this->client->submitForm('Envoyer', [
            'user[username]' => 'Mon Nom',
            'user[email]' => 'nouveau@gmail.com',
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
            'user[roles]' => 'ROLE_USER'
        ]);
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('div[class*="alert alert-success"]');
        $this->assertCount(1, $crawler->filter('h1'));
    }

    public function testUserCreateFailled()
    {
        $this->client->request('GET', '/admin/users/create');
        $this->assertResponseStatusCodeSame(302);
    }

    public function testUserUpdate()
    {
        $this->adminValidConnection();

        $crawler = $this->client->request('GET', '/admin/users/1/edit');
        $this->client->submitForm('Envoyer', [
            'user[username]' => 'Mon Nom Modifié',
            'user[email]' => 'roukoumanouamidou@gmail.com',
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
            'user[roles]' => 'ROLE_ADMIN'
        ]);
        $this->client->followRedirect();
        $this->assertSelectorExists('div[class*="alert alert-success"]');
        $this->assertCount(1, $crawler->filter('h1'));
    }
}
