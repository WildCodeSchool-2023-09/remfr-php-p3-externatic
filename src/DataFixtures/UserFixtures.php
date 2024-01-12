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

        // création admin
        $user = new User();
        $user->setEmail($faker->email());
        $user->setPassword($faker->password());
        $user->setFirstname($faker->firstName());
        $user->setLastname($faker->lastName());
        $user->setPhone($faker->phoneNumber());
        $user->setAddress($faker->address());
        $user->addRole("ROLE_ADMIN");
        $user->setZipcode($faker->postcode());
        $user->setCity($faker->city());
        $user->setContactPreference($faker->text(10));
        $user->setBirthdate($faker->dateTime());
        $user->setNationality($faker->countryCode());
        $user->setMaritalStatus(1);
        $manager->persist($user);

        // création collaborateur
        $collaborateur = [];
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setPassword($faker->password());
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setPhone($faker->phoneNumber());
            $user->setAddress($faker->address());
            $user->addRole("ROLE_COLLABORATEUR");
            $user->setZipcode($faker->postcode());
            $user->setCity($faker->city());
            $user->setContactPreference($faker->text(10));
            $user->setBirthdate($faker->dateTime());
            $user->setNationality($faker->countryCode());
            $user->setMaritalStatus($i % 2 + 1);
            $manager->persist($user);
            $collaborateur[] = $user;
        }

        //création candidats
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setPassword($faker->password());
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setPhone($faker->phoneNumber());
            $user->setCollaborateur($collaborateur[array_rand($collaborateur)]);
            $user->setAddress($faker->address());
            $user->setZipcode($faker->postcode());
            $user->setCity($faker->city());
            $user->setContactPreference($faker->text(10));
            $user->setBirthdate($faker->dateTime());
            $user->setNationality($faker->countryCode());
            $user->setMaritalStatus($i % 2 + 1);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
