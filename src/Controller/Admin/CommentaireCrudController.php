<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('contenu'),
            // TextEditorField::new('description'),
        ];
    }
}
