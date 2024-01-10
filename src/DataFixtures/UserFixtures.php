<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Inflector\Rules\Word;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\fr_FR\Text;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setPhone($faker->phoneNumber());
            $user->setAddress($faker->address());
            $user->setZipcode($faker->postcode());
            $user->setCity($faker->city());
            $user->setBirthdate($faker->dateTime());
            $user->setNationality($faker->countryCode());
            $user->setMaritalStatus($i % 2 + 1);
        }
        $manager->flush();
    }
}
