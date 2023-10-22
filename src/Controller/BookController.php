<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\BookRepository;
use App\Form\SearchBookType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/books', name: 'books_home')]
    public function index(
        BookRepository $bookRepository,
        Request $request
    ): Response
    {
        $books = $bookRepository->findAll();

        $form = $this->createForm(SearchBookType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $formData = $form->getData();
            $repoOptions = array();

            if($formData['title']){
                $repoOptions['title'] = array(
                    'type' => 'like',
                    'value' => $formData['title']
                );
            }

            if($formData['category']){
                $repoOptions['category'] = array(
                    'type' => '==',
                    'value' => $formData['category']->getId()
                );
            }

            if($formData['publicationDate']){
                $repoOptions['publication_date'] = array(
                    'type' => 'date',
                    'value' => $formData['publicationDate']
                );
            }

            $books = $bookRepository->searchBy($repoOptions);

            if(count($formData['authors']->getValues())){
                $displayedBooks = array();
                foreach($books as $book){
                    $toInclude = true;
                    foreach($formData['authors']->getValues() as $author){
                        $toInclude = $toInclude && in_array($author, $book->getAuthors()->getValues());
                    }
                    if($toInclude){
                        $displayedBooks[] = $book;
                    }
                }
                $books = $displayedBooks;
            }
        }

        $booksAvailability = array();
        foreach($books as $book){
            $booksAvailability[$book->getId()] = !$book->hasCurrentloan(); 
        }
        
        return $this->render('front/book/books.html.twig', [
            'books' => $books,
            'form' => $form,
            'isAvailable' => $booksAvailability
        ]);
    }

    #[Route('/books/{id}', name: 'books_one')]
    public function one(
        Book $book,
        Request $request,
        EntityManagerInterface $em
    ): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment = $form->getData();

            $comment->setUser($this->getUser());
            $comment->setBook($book);
            $comment->setPublicationDate(new DateTime());

            $em->persist($comment);
            $em->flush();
        }

        return $this->render('front/book/book.html.twig', [
            'book' => $book,
            'form' => $form,
            'isAvailable' => !$book->hasCurrentLoan()
        ]);
    }
}