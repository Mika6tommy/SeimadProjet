<?php

namespace App\Controller\Admin;

use App\Entity\Actualite;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ActualiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actualite::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Actualité')
        ->setEntityLabelInSingular('Actualité')
        ->setPageTitle('index', 'admnistrateur des actualités')
        ->setPaginatorPageSize(12);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('description'),
            // TextField::new('lieu'),
            AssociationField::new('provinces')
                ->setLabel('Lieux')
                // ->hideOnIndex(false)
                ->formatValue(function ($value, $entity) {
                    // Formatage personnalisé pour afficher les lieux dans l'index
                    $provinces = $entity->getProvinces()->map(function ($province) {
                        return $province->getLieu();
                    })->toArray();

                    return implode(', ', $provinces);
                }),
            TextField::new('LienImage')->setFormType(VichImageType::class)->onlyWhenCreating(),            
            ImageField::new('Lien')->setBasePath('assets/img')->onlyOnIndex(),
            DateTimeField::new('createdAt')->hideOnForm(),
        ]; 
        
    }
}
