<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CompanyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {
            $company = new Company();
            $company->setName($faker->company());
            $company->setField($faker->jobTitle());
            $company->setAddress($faker->city());
            $company->setDetails($faker->paragraphs(3, true));
            $companyReference = 'company_' . $i;
            $this->addReference($companyReference, $company);
            $manager->persist($company);
        }
        $manager->flush();
    }
}
