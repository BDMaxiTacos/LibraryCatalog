<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/books', name: 'books_home')]
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        
        return $this->render('front/book/books.html.twig', [
            'books' => $books
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