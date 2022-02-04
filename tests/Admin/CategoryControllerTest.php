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
}
