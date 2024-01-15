<?php

namespace App\Form;

use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, ['label' => 'Titre',
                'attr' => ['class' => 'form-control text-left'],])
            ->add('company', null, ['label' => 'Entreprise',
                'attr' => ['class' => 'form-control text-left'],])
            ->add('city', null, ['label' => 'Ville',
                'attr' => ['class' => 'form-control text-left'],])
                ->add('beginDate', null, ['label' => 'Année de début',
                'attr' => ['class' => 'form-control text-left'],
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy', ])
            ->add('endDate', null, ['label' => 'Année de fin',
                'attr' => ['class' => 'form-control text-left'],
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy', ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
