<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CourseController extends AbstractController
{
    // Pour afficher le formulaire d'ajout de cours
    #[Route('/course/new', name: 'course_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // On créer l'objet Course
        $course = new Course();

        // Création du formulaire
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        // On vérifie que le formulaire a été soumis et validé 
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($course);
            $entityManager->flush();

            $this->addFlash('success', 'Course created successfully!');
            return $this->redirectToRoute('course_index');
        }

        // Rendu du formulaire si problème
        return $this->render('course/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Afficher la liste des cours
    #[Route('/courses', name: 'course_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $courses = $entityManager->getRepository(Course::class)->findAll();

        return $this->render('course/index.html.twig', [
            'courses' => $courses,
        ]);
    }
    
    // Afficher un cours en particulier
    #[Route('/course/{id}', name:'course_show', methods:['GET'])]
    public function show(Course $course): Response
    {
        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }

    // Modifier un cours
    #[Route("/{id}/edit", name:"course_edit", methods:["GET", "POST"])]
    public function edit(Request $request, Course $course, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('course_index');
        }

        return $this->render('course/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Supprimer un cours
    #[Route("/{id}/delete", name:"course_delete", methods:["POST"])]
    public function delete(Request $request, Course $course, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $course->getId(), $request->request->get('_token'))) {
            $em->remove($course);
            $em->flush();
        }

        return $this->redirectToRoute('course_index');
    }
}
