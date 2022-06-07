<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $recette = new Commentaire();
        $recette->setUtilisateur($this->getUser());

        return $recette;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['date_commentaire' => 'DESC'])
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
        ;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('utilisateur')->hideOnForm(),
            AssociationField::new('recette')->hideWhenUpdating(),
            AssociationField::new('sujet')->hideWhenUpdating(),
            TextField::new('contenu'),
            IntegerField::new('type')->onlyOnForms(),
            DateField::new('date_commentaire')->hideOnForm(),
            DateField::new('date_moderation')->hideOnForm(),
        ];
    }
}
