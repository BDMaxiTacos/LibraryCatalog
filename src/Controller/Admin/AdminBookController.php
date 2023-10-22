<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminBookController extends AbstractController
{
    #[Route('/admin/books', name: 'admin_books')]
    public function books(
        BookRepository $bookRepository
    ): Response
    {
        $user = $this->getuser();

        $books = $bookRepository->findAll();

        $lastLoans = array();
        foreach ($books as $book){
            if(!$book->hasCurrentLoan()) {
                $lastLoans[$book->getId()] = "Disponible";
            }else{
                $lastLoans[$book->getId()] = "Non disponible";
            }
        }
        
        return $this->render('admin/book/index.html.twig', [
            'user' => $user,
            'books' => $books,
            'lastLoans' => $lastLoans
        ]);
    }

    #[Route('/admin/books/edit/{id}', name: 'admin_book_edit')]
    public function editBook(
        Book $book,
        Request $request, 
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $book = $form->getData();

            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('books_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Impossible d\'ajouter l\'image sur le livre');
                    return $this->redirectToRoute('admin_books');
                }

                $book->setImageUrl($this->getParameter('db_books_directory').$newFilename);
            }

            $em->flush();
            $this->addFlash('success', 'Le livre a bien été modifié');
            return $this->redirectToRoute('admin_books');
        }
        
        return $this->render('admin/book/form.html.twig', [
            'form' => $form,
            'book' => $book,
            'title' => 'Modifier un livre'
        ]);
    }

    #[Route('/admin/books/add', name: 'admin_book_add')]
    public function addBook(
        Request $request, 
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $book = $form->getData();

            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('books_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Impossible d\'ajouter l\'image sur le livre');
                    return $this->redirectToRoute('admin_books');
                }

                $book->setImageUrl($this->getParameter('db_books_directory').$newFilename);
            }
            
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
            $this->addFlash('success', 'Le livre a bien été supprimé');
        }else{
            $this->addFlash('error', 'Impossible de supprimer le livre');
        }
        return $this->redirectToRoute('admin_books');
    }

    #[Route('/admin/books/img-delete/{id}', name: 'admin_book_img_delete')]
    public function deleteImgFromBook(
        Book $book,
        Request $request, 
        EntityManagerInterface $em
    ): Response
    {
        if($this->isCsrfTokenValid('delete' . $book->getId(), $request->get('_token'))){
            unlink($this->getParameter('public_directory').$book->getImageUrl());

            $book->setImageUrl('');

            $em->flush();
            $this->addFlash('success', 'L\'image a bien été supprimée');
        }else{
            $this->addFlash('error', 'Impossible de supprimer l\'image');
        }
        return $this->redirectToRoute('admin_books');
    }
}