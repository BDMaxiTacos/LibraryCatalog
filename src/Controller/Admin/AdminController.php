<?php

namespace App\Controller\Admin;

use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_home')]
    public function index(): Response
    {
        $user = $this->getuser();
        
        return $this->render('admin/index.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/admin/books', name: 'admin_books')]
    public function books(BookRepository $bookRepository): Response
    {
        $user = $this->getuser();

        $books = $bookRepository->findAll();
        
        return $this->render('admin/book/index.html.twig', [
            'user' => $user,
            'books' => $books
        ]);
    }

    #[Route('/admin/authors', name: 'admin_authors')]
    public function authors(AuthorRepository $authorRepository): Response
    {
        $user = $this->getuser();

        $authors = $authorRepository->findAll();
        
        return $this->render('admin/author/index.html.twig', [
            'user' => $user,
            'authors' => $authors
        ]);
    }
}