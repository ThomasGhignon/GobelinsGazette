<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('content', TextareaType::class)
            ->add('likes')
            //fill author with default value
            //->add('author', EntityType::class, [
            //    'class' => User::class,
            //    'choice_label' => 'username',
            //    'data' => $this->security->getUser(),
            //])
            ->add(
                'author',ChoiceType::class
//                [
//                'choices'  => [
//                    'admin' => 1,
//                    'subscriber' => 2,
//                    'guest' => 3,
//                ],
//            ]
            )
            ->add('submit',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn btn-primary'
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
