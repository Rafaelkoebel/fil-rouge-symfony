<?php

namespace App\Controller;

use App\Entity\Sujet;
use App\Entity\Vente;
use App\Entity\Recette;
use App\Form\VenteType;
use App\Entity\Commande;
use App\Entity\Commentaire;
use App\Repository\SujetRepository;
use App\Repository\VenteRepository;
use App\Repository\RecetteRepository;
use App\Repository\CommandeRepository;
use App\Repository\CommentaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LigneCommandeRepository;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/annonce', name: 'annonce')]
    public function annonce(VenteRepository $venteRepository): Response
    {
        $utilisateur = $this->getUser('user');
        $ventes = $venteRepository->mesventes($utilisateur);
        return $this->render('compte/annonce.html.twig', [
            'ventes' => $ventes,
        ]);
    }

    #[Route('/commande', name: 'commande')]
    public function commande(): Response
    {
        return $this->render('compte/commande.html.twig', [
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

    #[Route('/annonce/delete/{id}', name: 'annonce_delete')]
    public function deleteannonce(Vente $vente, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($vente);
        $em->flush();
        // $this->addFlash('success', 'Post supprimé !');
        return $this->redirectToRoute('app_compte_annonce');
    }

    #[Route('/annonce/update/{id}', name: 'annonce_update')]
    public function updateannonce(Vente $vente, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(VenteType::class, $vente);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_compte_annonce');
        }
        // $this->addFlash('success', 'Post modifié !');
        return $this->render('annonce/add.html.twig', [
            'form' => $form->createView(),
        ]);    }

    
}
