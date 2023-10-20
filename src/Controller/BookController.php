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
        
        return $this->render('book/books.html.twig', [
            'books' => $books
        ]);
    }

    public function one($id, BookRepository $bookRepository): Response
    {
        $book = $bookRepository->findOneBy(['id' => $id]);

        return $this->render('book/one.html.twig', [
            'book' => $book
        ]);
    }
}