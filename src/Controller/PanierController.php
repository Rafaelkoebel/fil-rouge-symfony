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

        // On "fabrique" les données
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

        return $this->render('panier/index.html.twig', compact("dataPanier", "total"));

    }

    #[Route('/add/{id}', name: 'add')]
    public function add(Vente $vente, SessionInterface $session){

        // On récupère le panier actuel

        $panier = $session->get('panier', []);
        $id = $vente->getId();
        // $fruiti = $vente->getUtilisateur();
        // dd($vente);
        if (!empty($panier[$id])) {
            $panier[$id]++;
        }
        else {
            $panier[$id] = 1;
        }

        // if ($utilisateur != $panier[$utilisateur]) {
        //     $panier->remove($utilisateur);
        // }

        //On sauvegarde dans la session
        
        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier_index');

    }




    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Vente $vente, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $vente->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("app_panier_index");
    }



    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Vente $vente, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $vente->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        // On sauvegarde dans la session
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
