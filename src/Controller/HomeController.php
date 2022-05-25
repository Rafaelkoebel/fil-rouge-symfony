<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/', name: 'home')]
    public function categorie(CategorieRepository $categorieRepository): Response
    {
        $types = $categorieRepository->categorietype();
        return $this->render('home/index.html.twig', [
            'types' => $types,
        ]);
    }
}
