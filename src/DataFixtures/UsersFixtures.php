<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;
use Faker\Factory;

class UsersFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private SluggerInterface $slugger
    ){}

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');


        $admin = new Users();
        $admin->setEmail('abdou@wassa.fr');
        $admin->setLastname('Niare');
        $admin->setFirtsname('Abdou');
        $admin->getAddresses('04 rue de Toulouse');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'admin')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        for($usr = 1; $usr <= 4; $usr++){
            $user = new Users();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastName);
            $user->setFirtsname($faker->firstName);
            $user->getAddresses($faker->streetAddress);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'secret')
            );
            $manager->persist($user);
        }
        $manager->flush();
    }
}
