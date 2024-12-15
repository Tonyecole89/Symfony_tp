<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'user' => $user, 
        ]);
    }
}
