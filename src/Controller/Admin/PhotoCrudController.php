<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DomCrawler\Field\FileFormField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Photo::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id")->hideOnForm()->onlyWhenUpdating(),
            TextField::new('title'),
            AssociationField::new('albums')
            ->autocomplete()
            ->onlyOnForms(),
            TextField::new('imageFile')
            ->setLabel('Photo')
            ->setFormType(VichImageType::class)
            ->onlyOnForms(),
            ImageField::new('filename')
            ->setLabel('Photo')
            ->setBasePath('/photos')
            ->onlyOnIndex(),

            AssociationField::new('albums')
            ->onlyOnIndex(),

        ];
    }
}
