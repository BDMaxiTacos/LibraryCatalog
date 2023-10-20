<?php

namespace App\Controller\Admin;

use App\Entity\Book;
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
            $id, 
            BookRepository $bookRepository, 
            Request $request, 
            EntityManagerInterface $em
        ): Response
        {
            $book = $bookRepository->findOneBy(['id' => $id]);
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
                $this->addFlash('success', 'Impossible de supprimer l\'article');
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
}