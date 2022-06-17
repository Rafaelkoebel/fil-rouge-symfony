<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Form\CommandeType;
use App\Repository\VenteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(Request $request, ManagerRegistry $doctrine, SessionInterface $session, VenteRepository $venteRepository): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commande->setUtilisateur($this->getUser());
            $em = $doctrine->getManager();
            $em->persist($commande);
            $em->flush();
            
            $panier = $session->get('panier', []);
            $dataPanier = [];

            foreach($panier as $id => $quantite){
                $vente = $venteRepository->find($id);
                $dataPanier[] = [
                    "vente" => $vente,
                    "quantite" => $quantite
                ];
                $lignecommande = new LigneCommande();
                $lignecommande->setPrix($vente->getPrix());
                $lignecommande->setQuantite($quantite);
                $lignecommande->setCommande($commande);
                $lignecommande->setProduit($vente->getProduit());
                $em->persist($lignecommande);
                $em->flush();
            }
            return $this->redirectToRoute('app_panier_index');
        }

        return $this->render('commande/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
