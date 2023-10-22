<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Loan;
use App\Entity\User;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoanType extends AbstractType
{    
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $bookRepository = $this->entityManager->getRepository(Book::class);

        $books = array();
        $currentLoanStatus = array(1,2);
        foreach($bookRepository->findAll() as $book){
            $hasCurrentLoan = false;
            foreach ($book->getLoans() as $loan) {
                if(in_array($loan->getStatus(), $currentLoanStatus)){
                    $hasCurrentLoan = true;
                }
            }
            if(!$hasCurrentLoan){
                $books[] = $book;
            }
        }

        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'query_builder' => function(UserRepository $userRepository){
                    return $userRepository->createQueryBuilder('u')
                            //   ->andWhere('u.roles NOT LIKE :role')
                            //   ->setParameter('role', '%ROLE_LIBRARIAN%')
                              ->orderBy('u.username', 'ASC');
                },
                'choice_label' => 'username',
                'multiple' => false,
                'required' => true
            ])
            ->add('book', EntityType::class, [
                'class' => Book::class,
                'choices' => $books,
                'choice_label' => 'title',
                'multiple' => false,
                'required' => true
            ])
            ->add('limitDate', DateType::class, [
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Loan::class,
        ]);
    }
}
