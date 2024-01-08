<?php

namespace App\Form;

use App\Entity\CurriculumVitae;
use App\Entity\Education;
use App\Entity\Experience;
use App\Entity\Language;
use App\Entity\Links;
use App\Entity\Skill;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('educations', EntityType::class, [
                'class' => Education::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('languages', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('links', EntityType::class, [
                'class' => Links::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('experiences', EntityType::class, [
                'class' => Experience::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CurriculumVitae::class,
        ]);
    }
}
