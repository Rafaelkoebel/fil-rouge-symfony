<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/compte', name: 'app_compte_')]
class CompteController extends AbstractController
{
    #[Route('/recette', name: 'recette')]
    public function index(): Response
    {
        return $this->render('compte/recette.html.twig', [
            'controller_name' => 'CompteController',
        ]);
    }
}
