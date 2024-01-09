<?php

namespace App\DataFixtures;

use App\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OfferFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $salary = $faker->numberBetween(28000, 45000);
        $salary2 = $faker->numberBetween(45000, 60000);

        for ($i = 0; $i < 50; $i++) {
            $offer = new Offer();
            $offer->setName($faker->realText(30));
            $offer->setDescription($faker->realText(250));
            $offer->setAssignment($faker->realText(250));
            $offer->setCollaborator($faker->realText(50));
            $companyReference = 'company_' . $i;
            $offer->setCompany($this->getReference($companyReference));
            $offer->setMinSalary($salary);
            $offer->setMaxSalary($salary2);
            $offer->setContractType($i % 2 + 1);
            $offer->setRemote($i % 2);

            $manager->persist($offer);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            CompanyFixtures::class,
        ];
    }
}
