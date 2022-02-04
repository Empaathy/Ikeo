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

        $admin = new User();
        $admin->setEmail('admin@test.fr')
            ->setFullName('Geoffrey')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordHasher->hashPassword(
                $admin,
                "pass1234"
            ));
        $manager->persist($admin);

        $user = new User();
        $user->setEmail('user@test.fr')
            ->setFullName('Naïm Jhuboo')
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->passwordHasher->hashPassword(
                $user,
                "azerty123456"
            ));
        $manager->persist($user);


        $manager->flush();
    }
}
