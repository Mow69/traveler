<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setEmail('admin@traveler.com');

        $password = $this->encoder->encodePassword($admin, 'traveler');
        $admin->setPassword($password);

        $manager->persist($admin);
        $manager->flush();


        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            // Je crée un objet
            $fakeUser = new User();
            // J'affect ses attributs
            $fakeUser->setEmail($faker->email());
            $fakeUser->setPassword($faker->password());


            // J'indique à mon gestionnaire d'entités que je veux insérer cet objet en BDD
            $manager->persist($fakeUser);
        }

        $manager->flush();
    }
}
