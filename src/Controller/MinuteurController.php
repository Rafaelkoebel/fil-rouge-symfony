<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MinuteurController extends AbstractController
{
    #[Route('/minuteur', name: 'app_minuteur')]
    public function index(): Response
    {
        return $this->render('minuteur/index.html.twig', [
        ]);
    }
}
