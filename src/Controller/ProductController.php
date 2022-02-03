<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/{slug}", name="product_category", priority="-1")
     */
    public function category(
        $slug,
        CategoryRepository $categoryRepository
    ): Response {

        $category = $categoryRepository->findOneBy([
            'slug' => $slug,
        ]);

        if (!$category) {
            throw $this->createNotFoundException('La catégorie demandée n\'existe pas!');
        }

        return $this->render('product/category.html.twig', [
            'slug' => $slug,
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{category_slug}/{slug}", name="product_show")
     */
    public function show(
        $slug,
        ProductRepository $productRepository
    ): Response {
        $product = $productRepository->findOneBy([
            'slug' => $slug,
        ]);

        if (!$product) {
            throw $this->createNotFoundException(
                'Le produit demandé n\'existe pas!'
            );
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}