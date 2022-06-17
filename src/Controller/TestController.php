<?php

namespace App\Controller;

use App\Entity\Test;
use App\Entity\Test2;
use App\Form\TestType;
use App\Form\Test2Type;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $test = new Test();
        $test2 = new Test2();
        $form = $this->createForm(TestType::class, $test);
        $form2 = $this->createForm(Test2Type::class, $test2);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($test);
            $em->persist($test2);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('test/index.html.twig', [
            'form' => $form->createView(),
            // 'form2' => $form2->createView(),
        ]);
    }

    #[Route('/test2', name: 'app_test2')]
    public function index2(Request $request, ManagerRegistry $doctrine): Response
    {
        // $test = new Test();
        // // $test2 = new Test2();
        // $form = $this->createForm(TestType::class, $test);
        // // $form2 = $this->createForm(Test2Type::class, $test2);

        // $form->handleRequest($request);
        // if ($form->isSubmitted() && $form->isValid()) {
        //     $em = $doctrine->getManager();
        //     $em->persist($test);
        //     // $em->persist($test2);
        //     $em->flush();
        //     return $this->redirectToRoute('home');
        // }
        return $this->render('test/index2.html.twig', [
            // 'form' => $form->createView(),
        ]);
    }
}
