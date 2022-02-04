<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $slugger = new AsciiSlugger();
        $faker = Factory::create('fr_FR');

        for ($p = 0; $p < 100; $p++) {
            $product = new Product;
            $name = $faker->realtext(20);
            $product->setName($name)
                ->setPrice(mt_rand(50, 2000))
                ->setSlug(strtolower($slugger->slug($name)))
                ->setShortDesc($faker->realtext(150))
                ->setPoster('https://fakeimg.pl/200x200/?text=produit ' . $p)
                ->setCategory($this->getReference('category_' . rand(1, 4)));

            $manager->persist($product);
        }

        $manager->flush();
    }
}
