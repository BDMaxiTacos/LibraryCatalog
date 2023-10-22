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
        $associatedAuthors = array();
        foreach ($author->getBooks() as $book) {
            foreach ($book->getAuthors() as $authorToAdd) {
                if(!in_array($authorToAdd, $associatedAuthors) && $authorToAdd != $author){
                    $associatedAuthors[] = $authorToAdd;
                }
            }
        }

        $associatedCategories = array();
        foreach ($author->getBooks() as $book) {
            if(!in_array($book->getCategory(), $associatedCategories)){
                $associatedCategories[] = $book->getCategory();
            }
        }

        $booksAvailability = array();
        foreach($author->getBooks()->getValues() as $book){
            $booksAvailability[$book->getId()] = !$book->hasCurrentloan(); 
        }

        return $this->render('front/author/author.html.twig', [
            'author' => $author,
            'associatedAuthor' => $associatedAuthors,
            'associatedCategories' => $associatedCategories,
            'isAvailable' => $booksAvailability
        ]);
    }
}