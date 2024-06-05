<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Province;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class Property1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('city')
            ->add('address')
            ->add('postalCode')
            ->add('parking')
            ->add('provinces', EntityType::class, [
                'class' => Province::class,
                'choice_label' => 'provinces',
                'multiple' => true,
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('relation', EntityType::class, [
                'class' => Province::class,
                'choice_label' => 'id',
                'multiple' => true,
            
            ])
            ->add('Lien', FileType::class,[
                'required' =>false,
                'mapped' =>false,
                'constraints' =>[
                    new Image(['maxSize' => '5000k'])
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
