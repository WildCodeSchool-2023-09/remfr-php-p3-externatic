<?php

namespace App\Form;

use App\Entity\CurriculumVitae;
use App\Form\AdditionalInfoType;
use App\Form\EducationType;
use App\Form\ExperienceType;
use App\Form\LanguageType;
use App\Form\LinksType;
use App\Form\SkillType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('educations', CollectionType::class, [
                'entry_type' => EducationType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
                'prototype_name' => 'name2',  // Advised by Symfony
                'attr' => [
                    'data-prototype-name' => 'name2'  // Required by a2lix_sf_collection
                ],
                'entry_options' => [
                    'label' => false,
                ],])
            ->add('languages', CollectionType::class, [
                'entry_type' => LanguageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
                'prototype_name' => 'name2',  // Advised by Symfony
                'attr' => [
                    'data-prototype-name' => 'name2'  // Required by a2lix_sf_collection
                ],
                'entry_options' => [
                    'label' => false,
                ],])
            ->add('skills', CollectionType::class, [
                'entry_type' => SkillType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
                'prototype_name' => 'name2',  // Advised by Symfony
                'attr' => [
                    'data-prototype-name' => 'name2'  // Required by a2lix_sf_collection
                ],
                'entry_options' => [
                    'label' => false,
                ],])
            ->add('links', CollectionType::class, [
                'entry_type' => LinksType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
                'prototype_name' => 'name2',  // Advised by Symfony
                'attr' => [
                    'data-prototype-name' => 'name2'  // Required by a2lix_sf_collection
                ],
                'entry_options' => [
                    'label' => false,
                ],])
            ->add('experiences', CollectionType::class, [
                'entry_type' => ExperienceType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
                'prototype_name' => 'name2',  // Advised by Symfony
                'attr' => [
                    'data-prototype-name' => 'name2'  // Required by a2lix_sf_collection
                ],
                'entry_options' => [
                    'label' => false,
                ],])
            ->add('additionalInfo', CollectionType::class, [
                'entry_type' => AdditionalInfoType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
                'prototype_name' => 'name2',  // Advised by Symfony
                'attr' => [
                    'data-prototype-name' => 'name2'  // Required by a2lix_sf_collection
                ],
                'entry_options' => [
                    'label' => false,
                ],]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CurriculumVitae::class,
        ]);
    }
}
