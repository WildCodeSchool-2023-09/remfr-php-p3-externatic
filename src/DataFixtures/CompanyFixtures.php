<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

;

class CompanyFixtures extends Fixture
{
    public const COMPANIES = [
        [
            'name' => 'externatic',
            'field' => 'recrutement',
            'address' => 'canard qui boite',
        ],
        [
            'name' => 'wild code school',
            'field' => 'formation',
            'address' => 'rue de strasbourg',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::COMPANIES as $toto) {
            $company = new Company();
            $company->setName($toto['name']);
            $company->setField($toto['field']);
            $company->setAddress($toto['address']);

            $this->addReference($toto['name'], $company);

            $manager->persist($company);
        }
        $manager->flush();
    }
}
