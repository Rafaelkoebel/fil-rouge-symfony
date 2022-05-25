<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/recette', name: 'app_recette_')]
class RecetteController extends AbstractController
{
    #[Route('/confiture', name: 'confiture')]
    public function confiture(RecetteRepository $recetteRepository): Response
    {
        $recettes = $recetteRepository->findLastPostsconfiture();
        return $this->render('recette/apercut.html.twig', [
            'recettes' => $recettes,
        ]);
    }

    #[Route('/glace', name: 'glace')]
    public function glace(RecetteRepository $recetteRepository): Response
    {
        $recettes = $recetteRepository->findLastPostsglace();
        return $this->render('recette/apercut.html.twig', [
            'recettes' => $recettes,
        ]);
    }

    #[Route('/gateau', name: 'gateau')]
    public function gateau(RecetteRepository $recetteRepository): Response
    {
        $recettes = $recetteRepository->findLastPostsgateau();
        return $this->render('recette/apercut.html.twig', [
            'recettes' => $recettes,
        ]);
    }

    #[Route('/yaourt', name: 'yaourt')]
    public function yaourt(RecetteRepository $recetteRepository): Response
    {
        $recettes = $recetteRepository->findLastPostsyaourt();
        return $this->render('recette/apercut.html.twig', [
            'recettes' => $recettes,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addRecette(Request $request, ManagerRegistry $doctrine): Response
    {
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recette->setUtilisateur($this->getUser());
            $em = $doctrine->getManager();
            $em->persist($recette);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('recette/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{slug}', name: 'view')]
    public function recetteid(Recette $recette): Response
    {
        return $this->render('recette/view.html.twig', [
            'recette' => $recette
        ]);
    }
}
