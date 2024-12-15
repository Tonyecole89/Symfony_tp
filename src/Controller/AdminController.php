<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    // On récupère l'index de l'Admin
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    // Pour ajouter une catégorie
    #[Route('/category/add', name: 'category_add')]
    public function addCategory(Request $request, ManagerRegistry $doctrine): Response
    {
        // une nouvelle instance de Category
        $category = new Category();

        // Créer le formulaire et associer l'entité Category 
        $form = $this->createForm(CategoryType::class, $category);

        // AFin de traiter le formulaire
        $form->handleRequest($request);

        // On vérifier si le formulaire a été soumis et validé
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('admin_home');
        }

        // Afficher le formulaire dans la vue
        return $this->render('admin/category/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
