<?php

namespace App\Tests\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Controller\Admin\CategoryController;

class CategoryControllerTest extends WebTestCase
{
    public function testIndexExists()
    {
        $this->assertTrue(method_exists(CategoryController::class, 'index'));
    }

    /**
     * @dataProvider uriDirections
     */
    public function testExist($uri)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/map');
        $this->assertResponseIsSuccessful();
        $this->assertCount(1, $crawler->filter('.navigation a[href="' . $uri . '"]'));
    }
}
