<?php

namespace App\Form;

use App\Entity\CurriculumVitae;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class CurriculumVitaeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cvFile', VichFileType::class, [
            'download_label' => 'Télécharger mon cv déjà existant',
            'label' => 'Importer votre CV',
            'required' => false,
            'data_class' => null,
            'download_uri' => true,
            'delete_label' => 'Supprimer le fichier',
            'asset_helper' => true,
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
