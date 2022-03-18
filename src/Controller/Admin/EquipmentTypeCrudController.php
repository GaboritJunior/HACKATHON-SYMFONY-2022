<?php

namespace App\Controller\Admin;

use App\Entity\EquipmentType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EquipmentTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EquipmentType::class;
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
