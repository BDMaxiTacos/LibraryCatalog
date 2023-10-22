<?php

namespace App\Controller\Admin;

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
}