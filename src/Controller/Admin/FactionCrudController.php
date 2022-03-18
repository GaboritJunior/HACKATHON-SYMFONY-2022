<?php

namespace App\Controller\Admin;

use App\Entity\Faction;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FactionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Faction::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
