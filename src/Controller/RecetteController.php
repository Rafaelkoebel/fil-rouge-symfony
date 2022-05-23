<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecetteController extends AbstractController
{
    #[Route('/recette', name: 'app_recette')]
    public function index(): Response
    {
        return $this->render('recette/index.html.twig', [
            'controller_name' => 'RecetteController',
        ]);
    }

    #[Route('/recette/add', name: 'app_recette_add')]
    public function addRecette(Request $request): Response
    {
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);

        return $this->render('recette/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
