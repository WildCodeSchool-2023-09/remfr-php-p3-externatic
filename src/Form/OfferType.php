<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Offer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
