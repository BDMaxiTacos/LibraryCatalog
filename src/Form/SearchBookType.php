<?php
namespace App\Form;

use App\Entity\Author;
use App\Entity\Category;
use App\Repository\AuthorRepository;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, [
                'required' => false
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'query_builder' => function(AuthorRepository $authorRepository){
                    return $authorRepository->createQueryBuilder('a')
                              ->orderBy('a.name', 'ASC');
                },
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function(CategoryRepository $categoryRepository){
                    return $categoryRepository->createQueryBuilder('c')
                              ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('publicationDate', DateType::class, [
                'required' => false
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}