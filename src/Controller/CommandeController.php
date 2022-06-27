<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Entity\LigneCommande;
use App\Repository\VenteRepository;
use Symfony\Component\Mime\Address;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(Request $request, ManagerRegistry $doctrine, SessionInterface $session, VenteRepository $venteRepository, MailerInterface $mailer): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commande->setUtilisateur($this->getUser());
            $em = $doctrine->getManager();
            $em->persist($commande);
            
            $panier = $session->get('panier', []);
            $dataPanier = [];
            $total = 0;

            foreach($panier as $id => $quantite){
                $vente = $venteRepository->find($id);
                $dataPanier[] = [
                    "vente" => $vente,
                    "quantite" => $quantite,
                    "prix" => $vente->getPrix(),
                    "produit" => $vente->getProduit(),
                ];
                $total += $vente->getPrix() * $quantite;
                $lignecommande = new LigneCommande();
                $lignecommande->setPrix($vente->getPrix());
                $lignecommande->setQuantite($quantite);
                $lignecommande->setCommande($commande);
                $lignecommande->setProduit($vente->getProduit());
                $em->persist($lignecommande);
                $em->flush();
            }
            
            $email = (new TemplatedEmail())
            ->from(new Address('rougedelices@gmail.com', 'Rouge Délice'))
            ->bcc($commande->getUtilisateur()->getEmail(), $vente->getUtilisateur()->getEmail())
            ->subject('Votre commande')
            ->htmlTemplate('commande/detail_commande.html.twig')
            ->context([
                'dataPanier' => $dataPanier,
                'vendeur' => $vente->getUtilisateur()->getEmail(),
                'nom' => $commande->getNom(),
                'prenom' => $commande->getPrenom(),
                'adresseLivraison' => $commande->getAdresseLivraison(),
                'codePostal' => $commande->getCodePostal(),
                'ville' => $commande->getVille(),
                'pays' => $commande->getPays(),
                'telephone' => $commande->getTelephone(),
                'dateCommande' => $commande->getDateCommande(),
                'total' => $total,
            ])
            ;
            $mailer->send($email);


            $session->remove("panier");
            $this->addFlash('successpanier', 'Votre commande a bien été enregistrée, vous allez recevoir un email avec le détail de votre commande. Pensez à vérifiez dans vos spam');
            return $this->redirectToRoute('home');
        }

        return $this->render('commande/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/commande/{id}', name: 'app_commande_view')]
    public function commandeid(): Response
    {

        return $this->render('commande/view.html.twig', [
        ]);
    }

}
