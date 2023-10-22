<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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
        Request $request
    ): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $formData = $form->getData();

            $user = $this->getUser();

            if(!$user){
                $username = 'Anonyme';
            }else{
                $username = $user->getUserIdentifier();
            }

            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host       = $this->getParameter('mail_host');
            $mail->SMTPAuth   = true;
            $mail->Username   = '';
            $mail->Password   = '';
            $mail->Port       = $this->getParameter('mail_port');

            $mail->setFrom($this->getParameter('mail_from'), 'Mailer');
            $mail->addAddress($this->getParameter('mail_email'), 'Joe User');

            $email = $this->render('emails/contact.html.twig',[
                'form' => $formData,
                'date' => new \DateTime(),
                'username' => $username
            ])->getContent();

            $mail->isHTML(true);
            $mail->Subject = "Formulaire de contact";
            $mail->Body    = $email;

            try {
                $mail->send();
                $this->addFlash('success', 'Votre message a bien été envoyé');
            }catch(Exception $e){
                $this->addFlash('error', 'Votre message n\'a pas pu être envoyé');
            }
            return $this->redirectToRoute('home');
        }
        
        return $this->render('front/contact.html.twig', [
            'form' => $form
        ]);
    }
}