<?php

namespace App\Controller;

use App\Entity\Sujet;
use App\Form\SujetType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
//use App\Repository\CommentaireRepository;
use App\Repository\SujetRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/sujet', name: 'app_sujet_')]
class SujetController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function addSujet(Request $request, ManagerRegistry $doctrine): Response
    {
        $type=$request->query->get('type');
        $sujet = new Sujet();
        $form = $this->createForm(SujetType::class, $sujet, ['type' => $type]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sujet->setUtilisateur($this->getUser());
            $em = $doctrine->getManager();
            $em->persist($sujet);
            $em->flush();
            return $this->redirectToRoute('app_sujet_forum');
        }

        return $this->render('sujet/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/forum', name: 'forum')]
    public function forum(SujetRepository $sujetRepository): Response
    {
        $sujets = $sujetRepository->findLastPostssujet();
        return $this->render('sujet/apercut.html.twig', [
            'sujets' => $sujets,
        ]);
    }

    #[Route('/{slug}', name: 'view')]
    public function sujetid(Sujet $sujet, Request $request, ManagerRegistry $doctrine): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setUtilisateur($this->getUser());
            $commentaire->setSujet($sujet);
            $commentaire->setType(2);
            $em = $doctrine->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('app_sujet_view', array('slug' => $sujet->getSlug()));
        }

        return $this->render('sujet/view.html.twig', [
            'form' => $form->createView(),
            'commentaire' => $commentaire,
            'sujet' => $sujet
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deletesujet(Sujet $sujet, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($sujet);
        $em->flush();
        $this->addFlash('success', 'Sujet supprimé !');
        return $this->redirectToRoute('app_sujet_forum');
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
