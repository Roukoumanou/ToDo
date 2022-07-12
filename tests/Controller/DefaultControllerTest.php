<?php

namespace App\Tests\Controller;

use App\Tests\Utils\CustomWebTestCase;

class DefaultControllerTest extends CustomWebTestCase
{
    public function testHome(): void
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !');
        $this->assertCount(1, $crawler->filter('h1'));
    }
}
