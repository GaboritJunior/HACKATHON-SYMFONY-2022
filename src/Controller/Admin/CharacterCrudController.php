<?php

namespace App\Controller\Admin;

use App\Entity\Character;
use App\Entity\CharacterEquipment;
use App\Entity\CharacterResource;
use App\Form\CharacterEquipmentType;
use App\Form\CharacterResourceType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CharacterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Character::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username'),
            IntegerField::new('money'),
            AssociationField::new('user'),
            AssociationField::new('guild'),
            AssociationField::new('speciality'),
            AssociationField::new('faction'),

            CollectionField::new('equipments')
                ->setLabel('Ajouter un equipments')
                ->setEntryType(CharacterEquipmentType::class),

            CollectionField::new('resources')
                ->setLabel('Ajouter une resources')
                ->setEntryType(CharacterResourceType::class),
        ];
    }
}
