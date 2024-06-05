<?php

namespace App\Form;

use App\Entity\Actualite;
use App\Entity\Province;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class Actualite1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('lieu')
            ->add('provinces', EntityType::class, [
                'class' => Province::class,
                'choice_label' => 'lieu',
                'multiple' => true,
            ])
            ->add('Lien', FileType::class,[
                'required' =>false,
                'mapped' =>false,
                'constraints' =>[
                    new Image(['maxSize' => '50000k'])
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Actualite::class,
        ]);
    }
}
