<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFirstname($user['firstname']);
        $user->setLastname($user['lastname']);
        $user->setEmail($user['email']);
        $user->setPhone($user['phone']);
        $user->setPassword($user['password']);
        $user->setAdresse($user['adresse']);
        $user->setZipcode($user['zipcode']);
        $user->setCity($user['city']);
        $user->setRule($user['rule']);
        $user->setContactPreference($user['contactPreference']);
        $user->setBirthdate($user['birthdate']);
        $user->setNationality($user['nationality']);
        $user->setMaritalStatus($user['maritalStatus']);
        $manager->persist($user);
        $manager->flush();
    }
}
