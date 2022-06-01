<?php

namespace App\Controller;

use App\Repository\SujetRepository;
use App\Repository\RecetteRepository;
use App\Repository\CommentaireRepository;
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
        $commentaires = $commentaireRepository->mescommentairesrecette($utilisateur);
        $commentaires2 = $commentaireRepository->mescommentairessujet($utilisateur);
        return $this->render('compte/commentaire.html.twig', [
            'commentaires' => $commentaires,
            'commentaires2' => $commentaires2,
        ]);
    }
}
