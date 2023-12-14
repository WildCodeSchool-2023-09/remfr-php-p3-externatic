<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UsersFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $users = new USERS();
        $users->setFirstname($users['firstname']);
        $users->setLastname($users['lastname']);
        $users->setEmail($users['email']);
        $users->setPhone($users['phone']);
        $users->setPassword($users['password']);
        $users->setAdresse($users['adresse']);
        $users->setZipcode($users['zipcode']);
        $users->setCity($users['city']);
        $users->setRule($users['rule']);
        $users->setContactPreference($users['contactPreference']);
        $users->setBirthdate($users['birthdate']);
        $users->setNationality($users['nationality']);
        $users->setMaritalStatus($users['maritalStatus']);
        $manager->persist($users);
        $manager->flush();
    }
}
