<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Offer;
use App\Entity\Process;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProcessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('offer', EntityType::class, [
            'class' => Offer::class,
            'choice_label' => 'name',
        ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullname',
                'group_by' => function ($choice, $key, $value) {
                    if ($choice->hasRole('ROLE_ADMIN')) {
                        return 'Administrateur';
                    } elseif ($choice->hasRole('ROLE_COLLABORATEUR')) {
                        return 'Collaborateur';
                    }

                    return 'Candidat';
                }
            ])
            ->add('collaborateur', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullname',
                'group_by' => function ($choice, $key, $value) {
                    if ($choice->hasRole('ROLE_ADMIN')) {
                        return 'Administrateur';
                    } elseif ($choice->hasRole('ROLE_COLLABORATEUR')) {
                        return 'Collaborateur';
                    }

                    return 'Candidat';
                }
            ])
            ->add('statut', ChoiceType::class, [
                'choices'  => [
                    'Candidature envoyée' => 1,
                    'Candidature réceptionnée' => 2,
                    'Candidature en cours d\'examen' => 3,
                    'Entretien en cours' => 4,
                    'Candidat retenu pour le poste' => 5,
                    'Candidat non retenu pour le poste' => 6,
                    'Réponse reçue' => 7,
                ],
            ])
            ->add('process', ChoiceType::class, [
                'choices'  => [
                    'En cours' => 1,
                    'Terminé' => 2,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Process::class,
        ]);
    }
}
