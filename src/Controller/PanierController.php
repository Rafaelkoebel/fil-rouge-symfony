<?php

namespace App\Controller;

use App\Entity\Vente;
use App\Repository\VenteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/panier', name: 'app_panier_')]
class PanierController extends AbstractController
{
    public function index(SessionInterface $session, VenteRepository $venteRepository): Response
    {
        $panier = $session->get('panier', []);

        //On "fabrique" les données
        $dataPanier = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $produit = $venteRepository->find($id);
            $dataPanier = [
                'produit' => $produit,
                'quantite' => $quantite
            ];
            $total += $produit->getPrix();
        }

        return $this->render('panier/index.html.twig', [
        ]);
    }

    #[Route('/add/{id}', name: 'add')]
    public function add(Vente $vente, SessionInterface $session){

        // On récupère le panier actuel
        $panier = $session->get('panier', []);
        $id = $vente->getId();

        if (!empty($panier[$id])) {
            $panier[$id]++;
        }
        else {
            $panier[$id] = 1;
        }

        //On sauvegarde dans la session
        
        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier_');

        // dd($panier);
        // dd($session);
    }
}
