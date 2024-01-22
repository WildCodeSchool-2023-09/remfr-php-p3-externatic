<?php

namespace App\DataFixtures;

use App\Entity\Criteria;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CriteriaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $criteria = new Criteria();
            $criteria->setSalary($faker->numberBetween(28000, 60000));
            $criteria->setProfil($faker->sentence(1));
            $criteria->setContract($i % 2 + 1);
            $criteria->setLocation($faker->city());
            $criteria->setRemote($i % 2);
            $criteria->setUser($this->getReference('user_' . rand(0, 19)));
            $manager->persist($criteria);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
