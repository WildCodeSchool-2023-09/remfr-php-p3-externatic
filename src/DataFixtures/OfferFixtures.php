<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Company;
use App\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

;

class OfferFixtures extends Fixture
{
    public const OFFER = [
        [
            'name' => 'dev full stack',
            'assignement' => 'recrutement',
            'description' => 'symfont',
            'collaborator' => 'adrien',
            'company' => 'externatic',
        ],
        [
            'name' => 'dev front ',
            'assignement' => 'recrutement',
            'description' => 'javascript',
            'collaborator' => 'jessica',
            'company' => 'wild code school',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $offresObj = new Offer();
        $offresObj->setName("Offre #1");
        $offresObj->setAssignment("Assignement de l'offre");
        $offresObj->setDescription("Assignement de l'offre");
        $offresObj->setCollaborator("colab");
        $offresObj->setCompany($this->getReference(self::OFFER[0]['company']));

        $manager->persist($offresObj);
        $manager->flush();
    }
}
