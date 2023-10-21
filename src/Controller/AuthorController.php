<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/authors', name: 'authors_home')]
    public function index(AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAll();
        
        return $this->render('front/author/authors.html.twig', [
            'authors' => $authors
        ]);
    }

    #[Route('/authors/{id}', name: 'authors_one')]
    public function one(
        Author $author
    ): Response
    {
        return $this->render('front/author/author.html.twig', [
            'author' => $author
        ]);
    }
}