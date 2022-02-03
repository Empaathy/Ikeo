<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\AsciiSlugger;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
        'Meubles',
        'Décoration',
        'Rangement',
        'Lits et Matelas',
        'Linge de maison et textile',
    ];

    public function load(ObjectManager $manager): void
    {
        $slugger = new AsciiSlugger();

        foreach (self::CATEGORIES as $key => $categoryName) {
            $category = new Category;
            $category->setName($categoryName)
                ->setSlug(strtolower($slugger->slug($categoryName)));

            $manager->persist($category);
            $this->addReference('category_' . $key, $category);
        }

        $manager->flush();
    }
}
