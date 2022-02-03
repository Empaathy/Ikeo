<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Purchase;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;


    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setEmail('admin@test.fr')
            ->setFullName('Geoffrey')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordHasher->hashPassword(
                $user,
                "pass1234"
            ));
        $manager->persist($user);

        $user = new User();
        $user->setEmail('user@test.fr')
            ->setFullName('Naïm Jhuboo')
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->passwordHasher->hashPassword(
                $user,
                "azerty123456"
            ));
        $manager->persist($user);

        for ($u = 0; $u < 5; $u++) {
            $user = new User();
            $user->setEmail($faker->email())
                ->setFullName($faker->name())
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->passwordHasher->hashPassword(
                    $user,
                    "azerty123456"
                ));

            $manager->persist($user);
        }

        for ($p = 0; $p < mt_rand(20, 40); $p++) {
            $purchase = new Purchase;

            $purchase->setFullName($faker->name())
                ->setAddress($faker->streetAddress())
                ->setZip($faker->postcode())
                ->setCity($faker->city())
                ->setUser($faker
                ->setTotal(mt_rand(2000, 30000));
        }
        if ($faker->boolean(90)) {
            $purchase->setStatus(Purchase::STATUS_PAID);
        }
        $manager->persist($purchase);

        $manager->flush();
    }
}
