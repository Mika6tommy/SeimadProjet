<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Province;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('province', EntityType::class, [
                'class' => Province::class,
                'choice_label' => 'lieu',
                'multiple' => true,
            ])
            ->add('price')
            ->add('surface')
            ->add('rooms')
            // ->add('city')
            ->add('address')
            ->add('postalCode')
            ->add('parking')
            ->add('Lien', FileType::class,[
                'required' =>false,
                'mapped' =>false,
                // 'constraints' =>[
                //     new Image(['maxSize' => '50000M'])
                //]

            ])
            ->add('Save',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
