<?php

namespace App\Tests\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Controller\Admin\ProductController;

class ProductControllerTest extends WebTestCase
{
    public function testIndexExists()
    {
        $this->assertTrue(method_exists(ProductController::class, 'index'));
    }
}
