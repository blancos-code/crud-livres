<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/livre', name: 'app-livre')]
class LivreController extends AbstractController
{
    #[Route('/', name: '-index', methods: ['GET'])]
    public function index(LivreRepository $repository): Response
    {
        return $this->render('livre/index.html.twig', [
            'controller_name' => 'LivreController',
            'livres' => $repository->findAll(),
        ]);
    }

    #[Route('/create', name: '-create',methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($livre);
            $entityManager->flush();
            $this->addFlash('succès', 'Livre créé avec succès');
            return $this->redirectToRoute('app-livre-index');
        } else {
            if ($form->isSubmitted()) {
                $this->addFlash('danger', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render('Livre/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: '-edit', methods: ['GET', 'POST'])]
    public function edit(Livre $livre, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivreType::class, $livre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($livre);
            $entityManager->flush();

            $this->addFlash('succès', 'Livre édité avec succès');
            return $this->redirectToRoute('app-livre-index');
        } else {
            if ($form->isSubmitted()) {
                $this->addFlash('danger', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render('Livre/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: '-delete', methods: ['GET'])]
    public function delete(Livre $livre, Request $request, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($livre);
        $entityManager->flush();

        return $this->redirectToRoute('app-livre-index');
    }
}
