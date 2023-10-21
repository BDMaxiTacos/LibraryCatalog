<?php
namespace App\Form;

use App\Repository\AuthorRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, [
                'label' => 'Titre'
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'query_builder' => function(AuthorRepository $authorRepository){
                    return $authorRepository->createQueryBuilder('a')
                              ->orderBy('a.name', 'ASC');
                },
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function(CategoryRepository $categoryRepository){
                    return $categoryRepository->createQueryBuilder('c')
                              ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name'
            ])
            ->add('publicationDate', DateTimeType::class, [
                'label' => 'Date de publication'
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}