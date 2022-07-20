<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Vente;
use App\Repository\VenteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/panier', name: 'app_panier_')]
class PanierController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, VenteRepository $venteRepository): Response
    {
        $panier = $session->get("panier", []);

        $dataPanier = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $vente = $venteRepository->find($id);
            $dataPanier[] = [
                "vente" => $vente,
                "quantite" => $quantite
            ];
            $total += $vente->getPrix() * $quantite;
        }


        return $this->render('panier/index.html.twig', [
            'dataPanier' => $dataPanier,
            'total' => $total,
        ]);

    }

    #[Route('/add/{id}', name: 'add')]
    public function add(Vente $vente, SessionInterface $session){

        $panier = $session->get('panier', []);
        $id = $vente->getId();

        $fruitivente = $vente->getUtilisateur()->getId();

        if (empty($panier)) {
            $panier[$id] = 1;
        }
        else {
            $fruitipanier = $session->get('fruiti');
            if ($fruitipanier != $fruitivente) {
                $this->addFlash('refuse', 'Votre panier comporte des articles d\'un autre fournisseur, finalisé d\'abord votre commande avant de changer de fournisseur.');
                return $this->redirectToRoute('app_annonce_apercut');
            }
            if (!empty($panier[$id])) {
                $panier[$id]++;
            }
            else {
                $panier[$id] = 1;
            }
                
        }

        $session->set('fruiti', $fruitivente);
        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier_index');

    }




    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Vente $vente, SessionInterface $session)
    {
        $panier = $session->get("panier", []);
        $id = $vente->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("app_panier_index");
    }



    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Vente $vente, SessionInterface $session)
    {
        $panier = $session->get("panier", []);
        $id = $vente->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("app_panier_index");
    }



    #[Route('/delete', name: 'delete_all')]
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute("app_panier_index");
    }

}
