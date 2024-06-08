<?php

namespace App\Controller\Admin;

use App\Entity\PropertyImage;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PropertyImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PropertyImage::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Property Image')
            ->setEntityLabelInPlural('Property Images')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('imageName')
                ->setBasePath('/assets/img')
                ->onlyOnIndex(),
            TextField::new('imageName')
                ->setFormType(VichFileType::class)
                ->onlyOnForms(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::NEW)
            ->add(Crud::PAGE_INDEX, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DELETE)
        ;
    }
}
