<?php

// src/Controller/Admin/AlbumCrudController.php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Field\PassGenField;
use App\Form\PasswordGeneratorType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AlbumCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Album::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Album')
            ->setEntityLabelInPlural('Albums')
            ->overrideTemplate('crud/new', 'admin/album/new.html.twig'); // Ajoutez le chemin de votre template ici
    }

    public function configureFields(string $pageName): iterable
    {
        
        return [
            IdField::new("id")->hideOnForm()->onlyWhenUpdating(),
            TextField::new('name'),
            TextField::new('password')->onlyOnIndex(),
            PassGenField::new('passwordArray')->onlyOnForms()
            ->addCssClass('zdhhzdhjdhzdhzdhdz'),
        ];
    }
}
