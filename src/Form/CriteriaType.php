<?php

namespace App\Form;

use App\Entity\Criteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CriteriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('salary')
            ->add('profil')
            ->add('contract', ChoiceType::class, [
                'choices' => array_flip(Criteria::CONTRACT_TYPE),
                'label' => 'Type de contrat',
            ])
            ->add('location')
            ->add('remote', ChoiceType::class, [
                'choices' => array_flip(Criteria::REMOTE_CONDITIONS),
                'label' => 'Télétravail',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Criteria::class,
            'csrf_protection' => false,
        ]);
    }
}
