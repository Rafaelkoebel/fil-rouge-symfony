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
        // $fruiti = $ventes->getutilisateur()->getUserIdentifier();
        // dd($fruiti);
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

        // return $this->render('panier/index.html.twig', compact("dataPanier", "total"));

        return $this->render('panier/index.html.twig', [
            'dataPanier' => $dataPanier,
            'total' => $total,
            // 'vente' => $ventes,
        ]);

    }

    #[Route('/add/{id}', name: 'add')]
    public function add(Vente $vente, SessionInterface $session){

        // On récupère le panier actuel

        $panier = $session->get('panier', []);
        $id = $vente->getId();

        // recup les id des utilisateurs , des utilisateurs de vente/annonce //
        $fruitivente = $vente->getUtilisateur()->getId();

        
        // quantite de LA vente dans le panier //
        // dd($panier[$fruiti]);

        // id vente => quantite //
        // dd($panier);

        // id fruiticulteur(utilisateur) //
        // dd($fruitivente);



        // Si le panier est rempli, que l'id utilisateur dans le panier est diff de l'id de l'utilisateur de la vente //

        //Si le panier est vide
        if (empty($panier)) {
            $panier[$id] = 1;
        }
        else {
            //On récup le fruiti de la session
            $fruitipanier = $session->get('fruiti');
            //Si le fruiti de la session != fruitivente  -> message d'erreur
            if ($fruitipanier != $fruitivente) {
                $this->addFlash('refuse', 'Votre panier comporte des articles d\'un autre fournisseur, finalisé d\'abord votre commande avant de changer de fournisseur.');
                return $this->redirectToRoute('app_annonce_apercut');
            }
            //Si la vente = fruitipanier
            //Si la vente est déja dans la panier
            if (!empty($panier[$id])) {
                $panier[$id]++;
            }
            else {
                //Ajoute la ligne au panier
                $panier[$id] = 1;
            }
                
        }


        // if (!empty($panier[$id])) {
        //     $panier[$id]++;
        // }
        // else {
        //     $panier[$id] = 1;
        // }

        // if ($utilisateur != $panier[$utilisateur]) {
        //     $panier->remove($utilisateur);
        // }

        //On sauvegarde dans la session
        $session->set('fruiti', $fruitivente);
        $session->set('panier', $panier);

        //  dd($session);
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
