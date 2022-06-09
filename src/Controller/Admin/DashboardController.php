<?php

namespace App\Controller\Admin;

use App\Entity\Sujet;
use App\Entity\Produit;
use App\Entity\Recette;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\CategorieCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(CategorieCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Fil Rouge Symfony');
    }

//     public function configureMenuItems(): iterable
// {
//     return [

//         MenuItem::linkToCrud('Blog Posts', null, Utilisateur::class)
//             ->setPermission('ROLE_EDITOR'),
//     ];
// }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Front-Office', 'fa fa-home');
        yield MenuItem::linkToRoute('Front Office', 'fa fa-home', 'home');
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Recettes', 'fas fa-list', Recette::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-list', Categorie::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', Utilisateur::class)
        ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Produits', 'fas fa-list', Produit::class)
        ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Sujets', 'fas fa-list', Sujet::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-list', Commentaire::class);
    }
}
