<?php

namespace App\Controller;

use App\Entity\Sujet;
use App\Entity\Recette;
use App\Entity\Commentaire;
use App\Repository\SujetRepository;
use App\Repository\RecetteRepository;
use App\Repository\CommentaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/compte', name: 'app_compte_')]
class CompteController extends AbstractController
{
    #[Route('/recette', name: 'recette')]
    public function recette(RecetteRepository $recetteRepository): Response
    {
        $utilisateur = $this->getUser('user');
        $recettes = $recetteRepository->mesrecettes($utilisateur);
        return $this->render('compte/recette.html.twig', [
            'recettes' => $recettes,
        ]);
    }

    #[Route('/sujet', name: 'sujet')]
    public function sujet(SujetRepository $sujetRepository): Response
    {
        $utilisateur = $this->getUser('user');
        $sujets = $sujetRepository->messujets($utilisateur);
        return $this->render('compte/sujet.html.twig', [
            'sujets' => $sujets,
        ]);
    }

    #[Route('/commentaire', name: 'commentaire')]
    public function commentaire(CommentaireRepository $commentaireRepository): Response
    {
        $utilisateur = $this->getUser('user');
        // $commentaire = $this->getId('id');
        $commentaires = $commentaireRepository->mescommentairesrecette($utilisateur);
        $commentaires2 = $commentaireRepository->mescommentairessujet($utilisateur);

        // $em = $doctrine->getManager();
        // $em->remove($commentaire);
        // $em->flush();

        return $this->render('compte/commentaire.html.twig', [
            'commentaires' => $commentaires,
            'commentaires2' => $commentaires2,
        ]);
    }

    #[Route('/commentaire/delete/{id}', name: 'commentaire_delete')]
    public function deletecommentaire(Commentaire $commentaire, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($commentaire);
        $em->flush();
        // $this->addFlash('success', 'Post supprimé !');
        return $this->redirectToRoute('app_compte_commentaire');
    }

    #[Route('/sujet/delete/{id}', name: 'sujet_delete')]
    public function deletesujet(Sujet $sujet, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($sujet);
        $em->flush();
        // $this->addFlash('success', 'Post supprimé !');
        return $this->redirectToRoute('app_compte_sujet');
    }

    #[Route('/recette/delete/{id}', name: 'recette_delete')]
    public function deleterecette(Recette $recette, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($recette);
        $em->flush();
        // $this->addFlash('success', 'Post supprimé !');
        return $this->redirectToRoute('app_compte_recette');
    }
}
