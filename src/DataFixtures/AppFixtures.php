<?php

namespace App\DataFixtures;

use App\Entity\Country;
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
        // ADMIN
        $admin = new User();
        $admin->setEmail('admin@traveler.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $password = $this->encoder->encodePassword($admin, 'traveler');
        $admin->setPassword($password);

        $manager->persist($admin);

        // FAKERS
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            // Je crée un objet
            $fakeUser = new User();
            // J'affect ses attributs
            $fakeUser->setEmail($faker->email());
            $cryptFakePass = ($this->encoder->encodePassword($fakeUser, $faker->password()));
            $fakeUser->setPassword($cryptFakePass);

            // J'indique à mon gestionnaire d'entités que je veux insérer cet objet en BDD
            $manager->persist($fakeUser);
        }

        // COUNTRIES

        if (($countriesFile = fopen(__DIR__ . "\..\..\data\countries.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($countriesFile)) !== FALSE) {
                $country = new Country();
                $country->setName($data[0]);
                $manager->persist($country);
            }
            fclose($countriesFile);
        }

        $manager->flush();
    }




}
