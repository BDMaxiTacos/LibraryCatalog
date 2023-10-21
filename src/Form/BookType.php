<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Repository\AuthorRepository;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
            ])
            ->add('catchphrase', TextareaType::class, [
                'required' => true,
            ])
            ->add('summary', TextareaType::class, [
                'required' => true
                ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'query_builder' => function(AuthorRepository $authorRepository){
                    return $authorRepository->createQueryBuilder('a')
                              ->orderBy('a.name', 'ASC');
                },
                'choice_label' => 'name',
                'multiple' => true,
                'required' => true
            ])
            ->add('publicationDate', DateType::class, [
                'required' => true
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function(CategoryRepository $categoryRepository){
                    return $categoryRepository->createQueryBuilder('c')
                              ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'required' => true
            ])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Veuillez téléverser une image valide',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
