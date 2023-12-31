<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class, [
                'required' => true,
            ])
            ->add('subject',ChoiceType::class, [
                'choices' => [
                    'Livres' => 'Livres',
                    'Auteurs' => 'Auteurs',
                    'Emprunt' => 'Emprunt',
                    'Suggestion' => 'Suggestion'
                ],
                'required' => true,
            ])
            ->add('message', TextareaType::class, [
                'attr' => ['rows' => 7],
                'required' => true,
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}