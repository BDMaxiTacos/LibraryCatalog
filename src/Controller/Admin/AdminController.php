<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\AuthorType;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /** Books routes */
        #[Route('/admin/books', name: 'admin_books')]
        public function books(
            BookRepository $bookRepository
        ): Response
        {
            $user = $this->getuser();

            $books = $bookRepository->findAll();
            
            return $this->render('admin/book/index.html.twig', [
                'user' => $user,
                'books' => $books
            ]);
        }

        #[Route('/admin/books/edit/{id}', name: 'admin_book_edit')]
        public function editBook(
            Book $book,
            Request $request, 
            EntityManagerInterface $em
        ): Response
        {
            $form = $this->createForm(BookType::class, $book);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $book = $form->getData();

                $em->flush();
                $this->addFlash('success', 'Le livre a bien été modifié');
                return $this->redirectToRoute('admin_books');
            }
            
            return $this->render('admin/book/form.html.twig', [
                'form' => $form,
                'title' => 'Modifier un livre'
            ]);
        }

        #[Route('/admin/books/delete/{id}', name: 'admin_book_delete')]
        public function deleteBook(
            Book $book, 
            Request $request, 
            EntityManagerInterface $em
        ): Response
        {
            if($this->isCsrfTokenValid('delete' . $book->getId(), $request->get('_token'))){
                $em->remove($book);
                $em->flush();
                $this->addFlash('success', 'Votre article a bien été supprimé');
            }else{
                $this->addFlash('error', 'Impossible de supprimer l\'article');
            }
            return $this->redirectToRoute('admin_books');
        }

        #[Route('/admin/books/add', name: 'admin_book_add')]
        public function addBook(
            Request $request, 
            EntityManagerInterface $em
        ): Response
        {
            $book = new Book();
            $form = $this->createForm(BookType::class, $book);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $book = $form->getData();

                $book->setPublicationDate(new \DateTime());
                
                $em->persist($book);
                $em->flush();

                $this->addFlash('success', 'Le livre a bien été ajouté');
                return $this->redirectToRoute('admin_books');
            }
            
            return $this->render('admin/book/form.html.twig', [
                'form' => $form,
                'title' => 'Ajouter un livre'
            ]);
        }
    /** ---- */

    /** Author routes */
        #[Route('/admin/authors', name: 'admin_authors')]
        public function authors(
            AuthorRepository $authorRepository
        ): Response
        {
            $user = $this->getuser();

            $authors = $authorRepository->findAll();
            
            return $this->render('admin/author/index.html.twig', [
                'user' => $user,
                'authors' => $authors
            ]);
        }
        
        #[Route('/admin/authors/edit/{id}', name: 'admin_author_edit')]
        public function editAuthor(
            Author $author,
            Request $request, 
            EntityManagerInterface $em
        ): Response
        {
            $form = $this->createForm(AuthorType::class, $author);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $author = $form->getData();

                $em->flush();
                $this->addFlash('success', 'L\'auteur a bien été modifié');
                return $this->redirectToRoute('admin_authors');
            }
            
            return $this->render('admin/author/form.html.twig', [
                'form' => $form,
                'title' => 'Modifier un auteur'
            ]);
        }

        #[Route('/admin/authors/delete/{id}', name: 'admin_author_delete')]
        public function deleteAuthor(
            Author $author, 
            Request $request, 
            EntityManagerInterface $em
        ): Response
        {
            if($this->isCsrfTokenValid('delete' . $author->getId(), $request->get('_token'))){
                $em->remove($author);
                $em->flush();
                $this->addFlash('success', 'L\'auteur a bien été supprimé');
            }else{
                $this->addFlash('error', 'Impossible de supprimer l\'auteur');
            }
            return $this->redirectToRoute('admin_authors');
        }

        #[Route('/admin/authors/add', name: 'admin_author_add')]
        public function addAuthor(
            Request $request, 
            EntityManagerInterface $em
        ): Response
        {
            $author = new Author();
            $form = $this->createForm(AuthorType::class, $author);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $author = $form->getData();

                $author->setPublicationDate(new \DateTime());
                
                $em->persist($author);
                $em->flush();

                $this->addFlash('success', 'L\auteur a bien été ajouté');
                return $this->redirectToRoute('admin_authors');
            }
            
            return $this->render('admin/author/form.html.twig', [
                'form' => $form,
                'title' => 'Ajouter un auteur'
            ]);
        }
    /** ---- */
}