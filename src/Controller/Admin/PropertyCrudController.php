<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PropertyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Property::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Propriété')
        ->setEntityLabelInSingular('Propriété')
        ->setPageTitle('index', 'admnistrateur des propriétés')
        ->setPaginatorPageSize(12);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id') 
            ->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('description'),
            // TextField::new('provinces'),
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
            IntegerField::new('Rooms'),
            IntegerField::new('Price'),
            IntegerField::new('Surface'),
            TextField::new('Address'),
            CollectionField::new('galarie')
                ->setEntryType(PropertyImageType::class)
                ->allowAdd(true)
                ->allowDelete(true)
                ->setFormTypeOptions([
                    'by_reference' => false,
                ]),
        
            IntegerField::new('Parking'),
            TextField::new('LienImage')->setFormType(VichImageType::class)->onlyWhenCreating(),
            ImageField::new('Lien')
                ->setBasePath('/assets/img')
                ->onlyOnIndex(),
            // ImageField::new('LienImage', 'Lien Image')
            //     ->setFormType(VichImageType::class)
            //     ->onlyOnForms(),
            // ImageField::new('Lien', 'Lien Image')
            //     ->setBasePath('images/products') // Définir le chemin de base pour accéder aux images téléchargées
            //     ->onlyOnIndex(),
            // ImageField::new('LienImage', 'Lien Image')
            //     ->setFormType(VichImageType::class) // Définir le type de formulaire pour le téléchargement de l'image
            //     ->onlyOnForms(),

            DateTimeField::new('updatedAt', 'Last Updated')
                ->hideOnForm()
        ];
    }
    
}
