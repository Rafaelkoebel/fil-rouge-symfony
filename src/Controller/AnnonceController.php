<?php

namespace App\Controller;

use App\Entity\Vente;
use App\Entity\Produit;
use App\Form\VenteType;
use App\Repository\VenteRepository;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/annonce', name: 'app_annonce_')]
class AnnonceController extends AbstractController
{
    #[Route('', name: 'apercut')]
    public function apercut(VenteRepository $venteRepository, Produit $produit): Response
    {
        // $produit = new Produit();
        // $ventes = $venteRepository->findAll();
        // $produits = $produitRepository->findAll();
        $ventes = $venteRepository->findAllAnnonce();
        return $this->render('annonce/apercut.html.twig', [
            'ventes' => $ventes,
            'produit' => $produit,
        ]);
    }




    #[Route('/add', name: 'add')]
    public function annonceadd(Request $request, ManagerRegistry $doctrine): Response
    {
        $vente = new Vente();
        $form = $this->createForm(VenteType::class, $vente);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $vente->setUtilisateur($this->getUser());
            $em = $doctrine->getManager();
            $em->persist($vente);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('annonce/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
