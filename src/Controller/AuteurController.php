<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/auteur', name: 'app-auteur')]
class AuteurController extends AbstractController
{

    #[Route('/', name: '-index', methods: ['GET'])]
    public function index(AuteurRepository $repository): Response
    {
        return $this->render('auteur/index.html.twig', [
            'controller_name' => 'AuteurController',
            'auteurs' => $repository->findAll(),
        ]);
    }

    #[Route('/create', name: '-create',methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $auteur = new Auteur();
        $form = $this->createForm(AuteurType::class, $auteur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($auteur);
            $entityManager->flush();

            return $this->redirectToRoute('app-auteur-index');
        } else {
            $this->addFlash('danger', 'Le formulaire contient des erreurs');
        }

        return $this->render('Auteur/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: '-edit', methods: ['GET', 'POST'])]
    public function edit(Auteur $auteur, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AuteurType::class, $auteur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($auteur);
            $entityManager->flush();

            return $this->redirectToRoute('app-auteur-index');
        } else {
            $this->addFlash('danger', 'Le formulaire contient des erreurs');
        }

        return $this->render('Auteur/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: '-delete', methods: ['GET'])]
    public function delete(Auteur $auteur, Request $request, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($auteur);
        $entityManager->flush();

        return $this->redirectToRoute('app-auteur-index');
    }
}
