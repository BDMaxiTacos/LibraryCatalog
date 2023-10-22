<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAuthorController extends AbstractController
{
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
}