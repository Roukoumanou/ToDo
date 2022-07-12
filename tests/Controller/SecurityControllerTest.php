<?php

namespace App\Tests\Controller;

use App\Tests\Utils\CustomWebTestCase;

class SecurityControllerTest extends CustomWebTestCase
{
    public function testLoginWithValidCredentials()
    {
        $this->validConnection();
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('a[href="/logout"]');
    }

    public function testLoginWithInvalidCredentials()
    {
        $this->client->request('GET', '/login');
        $this->client->submitForm('Se connecter', [
            '_username' => 'roukoumanouamidou@gmail.com',
            '_password' => 'echec',
        ]);
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    
    public function testLogout()
    {
        $this->validConnection();
        $this->client->followRedirect();
        $this->client->clickLink('Se déconnecter');
        $this->client->followRedirect();
        $this->assertSelectorExists('a[href="/login"]');
    }
}
