<?php

namespace App\Controller;

use App\Entity\Sujet;
use App\Form\SujetType;
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
            return $this->redirectToRoute('home');
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
    public function recetteid(Sujet $sujet): Response
    {
        return $this->render('sujet/view.html.twig', [
            'sujet' => $sujet
        ]);
    }
}
