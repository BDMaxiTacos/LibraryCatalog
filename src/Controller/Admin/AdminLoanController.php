<?php

namespace App\Controller\Admin;

use App\Entity\Loan;
use App\Repository\LoanRepository;
use App\Form\LoanType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminLoanController extends AbstractController
{
    #[Route('/admin/loans', name: 'admin_loans')]
    public function loans(
        LoanRepository $loanRepository, 
        EntityManagerInterface $em
    ): Response
    {
        $user = $this->getuser();

        $loans = $loanRepository->findAll();

        $changeLoans = false;
        foreach($loans as $loan){
            if ($loan->getLimitDate() < new DateTime() && $loan->getStatus() > 0) {
                $loan->setStatus(2);
                $changeLoans = true;
            }
        }

        // dd($loans);

        if($changeLoans){
            $em->flush();
        }

        return $this->render('admin/loan/index.html.twig', [
            'user' => $user,
            'loans' => $loans,
            'status' => Loan::STATUS
        ]);
    }
    
    #[Route('/admin/loans/edit/{id}', name: 'admin_loan_edit')]
    public function editLoan(
        Loan $loan,
        Request $request, 
        EntityManagerInterface $em
    ): Response
    {
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $baseDate = $loan->getLoanDate();
            $loan = $form->getData();

            $loan->setLoanDate($baseDate);

            $em->flush();
            $this->addFlash('success', 'L\'emprunt a bien été modifié');
            return $this->redirectToRoute('admin_loans');
        }
        
        return $this->render('admin/loan/form.html.twig', [
            'form' => $form,
            'title' => 'Modifier un emprunt'
        ]);
    }

    #[Route('/admin/loans/add', name: 'admin_loan_add')]
    public function addLoan(
        Request $request, 
        EntityManagerInterface $em
    ): Response
    {
        $loan = new Loan();
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $loan = $form->getData();

            $loan->setLoanDate(new \DateTime());
            $loan->setStatus(1);
            
            $em->persist($loan);
            $em->flush();

            $this->addFlash('success', 'L\'emprunt a bien été pris en compte');
            return $this->redirectToRoute('admin_loans');
        }
        
        return $this->render('admin/loan/form.html.twig', [
            'form' => $form,
            'title' => 'Ajouter un emprunt'
        ]);
    }

    #[Route('/admin/loans/return/{id}', name: 'admin_loan_return')]
    public function returnLoan(
        Loan $loan, 
        Request $request, 
        EntityManagerInterface $em
    ): Response
    {
        if($this->isCsrfTokenValid('return' . $loan->getId(), $request->get('_token'))){
            $loan->setStatus(0);

            $em->flush();

            $this->addFlash('success', 'Le livre a bien été retourné');
        }else{
            $this->addFlash('error', 'Impossible de retourner le livre');
        }
        return $this->redirectToRoute('admin_loans');
    }
}