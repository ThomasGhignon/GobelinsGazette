<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class EditUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class,[
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Merci d\'entrer un e-mail',
                    ]),
                ],
                'required' => true,
                'attr' => ['class' =>'form-control'],
            ])
            ->add('email', EmailType::class,[
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Merci d\'entrer un e-mail',
                    ]),
                ],
                'required' => true,
                'attr' => ['class' =>'form-control'],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Editeur' => 'ROLE_EDITOR',
                    'Administrateur' => 'ROLE_ADMIN'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles'
            ])
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
