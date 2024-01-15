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
        $admin = new User();
        $admin->setEmail($faker->email());
        $admin->setPassword($faker->password());
        $admin->setFirstname($faker->firstName());
        $admin->setLastname($faker->lastName());
        $admin->setPhone($faker->phoneNumber());
        $admin->setAddress($faker->address());
        $admin->addRole("ROLE_ADMIN");
        $admin->setZipcode($faker->postcode());
        $admin->setCity($faker->city());
        $admin->setContactPreference($faker->text(10));
        $admin->setBirthdate($faker->dateTime());
        $admin->setNationality($faker->countryCode());
        $admin->setMaritalStatus(1);
        $manager->persist($admin);

        // création collaborateur
        $collaborateurArray = [];
        for ($i = 0; $i < 5; $i++) {
            $collaborator = new User();
            $collaborator->setEmail($faker->email());
            $collaborator->setPassword($faker->password());
            $collaborator->setFirstname($faker->firstName());
            $collaborator->setLastname($faker->lastName());
            $collaborator->setPhone($faker->phoneNumber());
            $collaborator->setAddress($faker->address());
            $collaborator->addRole("ROLE_COLLABORATEUR");
            $collaborator->setZipcode($faker->postcode());
            $collaborator->setCity($faker->city());
            $collaborator->setContactPreference($faker->text(10));
            $collaborator->setBirthdate($faker->dateTime());
            $collaborator->setNationality($faker->countryCode());
            $collaborator->setMaritalStatus($i % 2 + 1);
            $manager->persist($collaborator);
            $collaborateurArray[] = $collaborator;
        }

        //création candidats
        for ($i = 0; $i < 20; $i++) {
            $candidat = new User();
            $candidat->setEmail($faker->email());
            $candidat->setPassword($faker->password());
            $candidat->setFirstname($faker->firstName());
            $candidat->setLastname($faker->lastName());
            $candidat->setPhone($faker->phoneNumber());
            $candidat->setCollaborateur($collaborateurArray[array_rand($collaborateurArray)]);
            $candidat->setAddress($faker->address());
            $candidat->setZipcode($faker->postcode());
            $candidat->setCity($faker->city());
            $candidat->setContactPreference($faker->text(10));
            $candidat->setBirthdate($faker->dateTime());
            $candidat->setNationality($faker->countryCode());
            $candidat->setMaritalStatus($i % 2 + 1);
            $manager->persist($candidat);
        }
        $manager->flush();
    }
}
