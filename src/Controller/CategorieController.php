<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categorie', name: 'app-categorie')]
class CategorieController extends AbstractController
{

    #[Route('/', name: '-index', methods: ['GET'])]
    public function index(CategorieRepository $repository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'categories' => $repository->findAll(),
        ]);
    }

    #[Route('/create', name: '-create',methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app-categorie-index');
        } else {
            $this->addFlash('danger', 'Le formulaire contient des erreurs');
        }

        return $this->render('Categorie/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: '-edit', methods: ['GET', 'POST'])]
    public function edit(Categorie $categorie, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app-categorie-index');
        } else {
            $this->addFlash('danger', 'Le formulaire contient des erreurs');
        }

        return $this->render('Categorie/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: '-delete', methods: ['GET'])]
    public function delete(Categorie $categorie, Request $request, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($categorie);
        $entityManager->flush();

        return $this->redirectToRoute('app-categorie-index');
    }
}
