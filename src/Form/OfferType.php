<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Offer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('company', EntityType::class, [
            'class' => Company::class,
            'choice_label' => 'name',
        ])
            ->add('Name')
            ->add('description')
            ->add('assignment')
            ->add('collaborator')
            ->add('minSalary')
            ->add('maxSalary')
            ->add('contractType', ChoiceType::class, [
                'choices'  => [
                    'CDI' => 1,
                    'CDD' => 2,
                    'Intérim' => 3,
                    'Freelance' => 4,
                    'Stage' => 5,
                    'Alternance' => 6,
                    'Bénévolat' => 7,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
