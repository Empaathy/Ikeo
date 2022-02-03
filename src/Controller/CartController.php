<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="show")
     */
    public function show(CartService $cartService): Response
    {
        $cart = $cartService->getCartItems();

        $totalCart = $cartService->getTotal();

        return $this->render('cart/index.html.twig', [
            'items' => $cart,
            'total' => $totalCart,
        ]);
    }

    /**
     * @Route("/add/{slug}", name="add", requirements={"slug":"^[a-z0-9]+(?:-[a-z0-9]+)*$"})
     */
    public function add(string $slug, Request $request, ProductRepository $productRepository, CartService $cartService)
    {
        $product = $productRepository->findOneBy([
            'slug' => $slug,
        ]);
        if (!$product) {
            throw $this->createNotFoundException("Le produit que vous recherchez n'existe pas!");
        }
        $cartService->add($slug);

        $this->addFlash('success', "Le produit a bien été ajouté au panier. Joli choix!");

        if ($request->query->get('returnToCart')) {
            return $this->redirectToRoute('cart_show');
        }

        return $this->redirectToRoute('product_show', [
            'slug' => $product->getSlug(),
            'category_slug' => $product->getCategory()->getSlug(),
        ]);
    }

    /**
     * @Route("/delete/{slug}", name="delete", requirements={"slug":"^[a-z0-9]+(?:-[a-z0-9]+)*$"})
     */
    public function delete(string $slug, ProductRepository $productRepository, CartService $cartService)
    {
        $product = $productRepository->findOneBy(['slug' => $slug]);

        if (!$product) {
            throw $this->createNotFoundException("Le produit n'existe pas et ne peut donc pas être supprimé");
        }

        $cartService->remove($slug);
        $this->addFlash('success', 'Le produit a bien été supprimé du panier');

        return $this->redirectToRoute('cart_show');
    }

    /**
     * @Route("/less/{slug}", name="less", requirements={"slug":"^[a-z0-9]+(?:-[a-z0-9]+)*$"})
     */
    public function removeOne(string $slug, ProductRepository $productRepository, CartService $cartService)
    {
        $product = $productRepository->findOneBy(['slug' => $slug]);

        if (!$product) {
            throw $this->createNotFoundException("Le produit n'existe pas et ne peut donc pas être supprimé");
        }

        $cartService->removeOne($slug);
        return $this->redirectToRoute('cart_show');
    }
}
