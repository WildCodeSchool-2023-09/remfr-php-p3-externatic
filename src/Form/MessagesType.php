<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Messages;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessagesType extends AbstractType
{
    public function __construct(private UserRepository $userRepository, private Security $security)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentUser = $this->security->getUser();
        $users = $this->userRepository->findAll();
        $collaborateurs = [];
        foreach ($users as $user) {
            if (in_array('ROLE_COLLABORATEUR', $user->getRoles())) {
                $collaborateurs[] = $user;
            }
        }

        $builder
            ->add('title')
            ->add('message')
            ->add('recipient', EntityType::class, [
                'class' => User::class,
                'choices' => in_array('ROLE_COLLABORATEUR', $currentUser->getRoles()) ? $users : $collaborateurs,
                'choice_label' => 'lastname',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}
