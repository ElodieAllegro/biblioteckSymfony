<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFictures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder,
    private SluggerInterface $slugger)
    {}
    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setEmail('admin@example.com');
        $admin->setLastname('Allegro');
        $admin->setFirstname('Elodie');
        $admin->setAddress('29 rue Jean-Claude Gresset');
        $admin->setZipcode('13140');
        $admin->setCity('Miramas');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin,'admin')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);


        $faker = Faker\Factory::create('fr_FR');

        for($usr =1; $usr <= 5; $usr++){
        
        $user = new Users();
        $user->setEmail($faker->email);
        $user->setLastname($faker->lastName);
        $user->setFirstname($faker->firstName);
        $user->setAddress($faker->streetAddress);
        $user->setZipcode(str_replace(' ', '', $faker->postcode));
        $user->setCity($faker->city);
        $user->setPassword(
            $this->passwordEncoder->hashPassword($admin,'secret')
        );

       
        $manager->persist($user);
        }

        $manager->flush();
    }
}
