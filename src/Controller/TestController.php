<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        // $nom = $form->handleRequest($request);
        return $this->render('test/index.html.twig', [
        ]);
    }

    #[Route('/test2', name: 'app_test2')]
    public function index2(Request $request): Response
    {
        dd($request);
        // $nom = $form->handleRequest($request);
        return $this->render('test/index2.html.twig', [
            // 'form' => $nom,
        ]);
    }
}
