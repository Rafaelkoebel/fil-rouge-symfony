<?php

namespace App\Controller\Admin;

use App\Entity\Sujet;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SujetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sujet::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['date_publication' => 'DESC'])
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
        ;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('utilisateur'),
            AssociationField::new('categorie'),
            TextField::new('titre'),
            TextField::new('slug')->hideOnForm(),
            TextEditorField::new('contenu')->onlyOnForms()->setFormType(CKEditorType::class),
            DateField::new('date_publication')->hideOnForm(),
        ];
    }
}
