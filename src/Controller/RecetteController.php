<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
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
        $type=$request->query->get('type');
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette, ['type' => $type]);

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
    public function recetteid(Recette $recette, Request $request, ManagerRegistry $doctrine): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setUtilisateur($this->getUser());
            $commentaire->setRecette($recette);
            $commentaire->setType('recette');
            $em = $doctrine->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('app_recette_view', array('slug' => $recette->getSlug()));
        }
        return $this->render('recette/view.html.twig', [
            'form' => $form->createView(),
            'commentaire' => $commentaire,
            'recette' => $recette
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleterecette(Recette $recette, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($recette);
        $em->flush();
        $this->addFlash('success', 'Recette supprimée !');
        return $this->redirectToRoute('home');
    }

    #[Route('/commentaire/delete/{id}', name: 'commentaire_delete')]
    public function deletecommentaire(Commentaire $commentaire, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($commentaire);
        $em->flush();
        $this->addFlash('success', 'Commentaire supprimé !');
        return $this->redirectToRoute('app_compte_commentaire');
    }
}
