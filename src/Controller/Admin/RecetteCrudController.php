<?php

namespace App\Controller\Admin;

use App\Entity\Recette;
use App\Repository\CategorieRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RecetteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recette::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $recette = new Recette();
        $recette->setUtilisateur($this->getUser());

        return $recette;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['date_publication' => 'DESC'])
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            // this will forbid to create or delete entities in the backend
            ->disable(Action::NEW)
        ;
    }

    
    public function configureFields(string $pageName): iterable
    {
        $type = 1;
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('utilisateur')->hideOnForm(),
            TextField::new('titre'),
            TextField::new('slug')->hideOnForm(),
            AssociationField::new('categorie')->setFormTypeOptions([
                'query_builder' => function(CategorieRepository $repository) use($type) {
                    return $repository->categorietype($type);
                }
            ]),
            IntegerField::new('temps_total'),
            IntegerField::new('temps_preparation'),
            IntegerField::new('temps_cuisson'),
            TextEditorField::new('instruction')->onlyOnForms()->setFormType(CKEditorType::class),
            ImageField::new('image')->hideOnForm(),
            DateField::new('date_publication')->hideOnForm(),
            DateField::new('date_moderation')->hideOnForm(),
        ];
    }
}
