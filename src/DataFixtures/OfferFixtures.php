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
            $offer->setName($faker->jobTitle());
            $offer->setDescription($faker->realText(250));
            $offer->setAssignment($faker->city());
            $offer->setCollaborator($faker->name());
            $companyReference = 'company_' . $i;
            $offer->setCompany($this->getReference($companyReference));
            $offer->setMinSalary($salary);
            $offer->setMaxSalary($salary2);
            $offer->setContractType($i % 6 + 1);
            $offer->setRemote($i % 6);

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
