<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Form\SearchBookType;
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
        
        return $this->render('front/book/books.html.twig', [
            'books' => $books,
            'form' => $form
        ]);
    }

    #[Route('/books/{id}', name: 'books_one')]
    public function one(
        Book $book
    ): Response
    {
        return $this->render('front/book/book.html.twig', [
            'book' => $book
        ]);
    }
}