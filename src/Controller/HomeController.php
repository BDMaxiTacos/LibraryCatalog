<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\BookRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        BookRepository $bookRepository
    ): Response
    {
        $latest = $bookRepository->latest();
        
        return $this->render('front/home.html.twig', [
            'books' => $latest
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(
        Request $request,
        MailerInterface $mailer
    ): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $formData = $form->getData();

            // dd($formData);

            $user = $this->getUser();

            if(!$user){
                $username = 'Anonyme';
            }else{
                $username = $user->getUserIdentifier();
            }

            $email = (new TemplatedEmail())
                        ->from('no-reply@library.fr')
                        ->to(new Address('test@mailhog.local'))
                        ->subject('Formulaire de contact')
                        ->htmlTemplate('emails/contact.html.twig')
                        ->context([
                            'form' => $formData,
                            'date' => new \DateTime(),
                            'username' => $username
                        ])
            ;

            if(!$mailer->send($email)){
                $this->addFlash('error', 'Votre message n\'a pas pu être envoyé');
            }else{
                $this->addFlash('success', 'Votre message a bien été envoyé');
            }
            
            return $this->redirectToRoute('home');
        }
        
        return $this->render('front/contact.html.twig', [
            'form' => $form
        ]);
    }
}