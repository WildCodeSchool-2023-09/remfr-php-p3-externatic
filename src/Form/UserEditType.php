<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Criteria;
use App\Entity\CurriculumVitae;
use App\Entity\Offer;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('phone', TextType::class)
            ->add('password', PasswordType::class)
            ->add('address', TextType::class)
            ->add('city', TextType::class)
            ->add('zipcode', TextType::class)
            ->add('contactPreference', ChoiceType::class, [
                'choices' => [
                    'Téléphone' => 'Téléphone',
                    'Email' => 'Email',
                    'Courrier' => 'Courrier',
                ],
            ])
            ->add('nationality', TextType::class)
            ->add('birthdate', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('maritalStatus', ChoiceType::class, [
                'choices' => array_flip(User::MARITAL_STATUS)
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
