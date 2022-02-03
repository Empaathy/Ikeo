<?php

namespace App\Service;

use App\Entity\CartItem;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    protected $session;

    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function add(string $slug)
    {
        $cart = $this->session->get('cart', []);

        if (array_key_exists($slug, $cart)) {
            $cart[$slug]++;
        } else {
            $cart[$slug] = 1;
        }

        $this->session->set('cart', $cart);
    }

    public function getTotal(): int
    {
        $total = 0;
        foreach ($this->session->get('cart', []) as $slug => $qty) {
            $product = $this->productRepository->findOneBy(['slug' => $slug]);

            if (!$product) {
                continue;
            }

            $total += $product->getPrice() * $qty;
        }
        return $total;
    }

    public function getCartItems(): array
    {
        $cart = [];
        foreach ($this->session->get('cart', []) as $slug => $qty) {
            $product = $this->productRepository->findOneBy(['slug' => $slug]);

            if (!$product) {
                continue;
            }

            $cart[] = new CartItem($product, $qty);
        }
        return $cart;
    }

    public function remove(string $slug): void
    {
        $cart = $this->session->get('cart', []);

        unset($cart[$slug]);
        $this->session->set('cart', $cart);
    }

    public function removeOne(string $slug)
    {
        $cart = $this->session->get('cart', []);

        if (!array_key_exists($slug, $cart)) {
            return;
        }
        if ($cart[$slug] === 1) {
            $this->remove($slug);
            return;
        }

        $cart[$slug]--;

        $this->session->set('cart', $cart);
    }
}
