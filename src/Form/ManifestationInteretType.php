<?php 
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ManifestationInteretType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('Nom')
            ->add('Prenom', TextType::class, [
                'label' => "Prénom"
                ])
            ->add('Email')
            ->add('Adresse')
            ->add('Numero', TextType::class, [
                'label' => "Numéro"
                ])
            ->add('profession')

            // ...
            ->add('StatutProfessionnel', ChoiceType::class, [
                'choices' => [
                    'Salarié' => 'choix 1',
                    'Profession libérale' => 'Profession libérale',
                    // Ajoutez autant de choix que nécessaire
                ],
                // Optionnel : définir le choix par défaut
                'expanded' => true,
            ])
            ->add('LesRenseignement', ChoiceType::class, [
                'choices' => [
                    'Conjointe' => 'valeur_1',
                    'Coaquéreur' => 'valeur_2',
                    // Ajoutez autant de choix que nécessaire
                ],
                // Optionnel : définir le choix par défaut
                'placeholder' => 'Choisissez une option',
            ])
            ->add('Nom')
            ->add('Prenom', TextType::class, [
                'label' => "prénom"
                ])
            ->add('Profession', ChoiceType::class, [
                'choices' => [
                    'Salarié' => 'Salarié',
                    'Fonctionnaire' => 'choix 2',
                    'Profession libérale ' => 'choix 3',
                    // Ajoutez autant de choix que nécessaire
                ],
                // Optionnel : définir le choix par défaut
                'expanded' => true,
            ])
            ->add('etablissementEmployeur', TextType::class, [
                'label' => "Si salarié, établissement employeur *:"
                ])            
            ->add('revenuMensuelAutresActivites' , TextType::class, [
                'label' => "Revenu mensuel dans d'autres activités :",
                ])
            ->add('revenuMensuelNet', ChoiceType::class, [
                'choices' => [
                    '200.000 AR à 500.000Ar' => '200.000 AR à 500.000Ar',
                    '500.000 Ar à 1.000.000 Ar' => '500.000 Ar à 1.000.000 Ar',
                    '1.000.000 Ar à 1.500.000 Ar' => '1.000.000 Ar à 1.500.000 Ar',
                    '2.000.000 Ar ou plus' => '2.000.000 Ar ou plus',
                    // Ajoutez autant de choix que nécessaire
                ],
                // Optionnel : définir le choix par défaut
                'placeholder' => 'Choisissez une option',
            ])            
            ->add('situationActuelle', ChoiceType::class, [
                'label' => "Etes-vous actuellement :",
                'choices' => [
                    'Salarié' => 'choix_1',
                    'Propriétaire ' => 'choix_2',
                    'Gratuitement logé ' => 'choix_3',
                    'Logé par l\'employeur' => 'choix_4',
                    // Ajoutez autant de choix que nécessaire
                ],
                // Optionnel : définir le choix par défaut
                'expanded' => true,
            ])
            ->add('dePreferenceA', TextType::class, [
                'label' => "De préférence à :"
                ])
            ->add('projetSEIMAD', TextType::class, [
                'label' => "Projet SEIMad :"
                ])
            ->add('typeMaison', ChoiceType::class, [
                'label' => "Type de maison :",
                'choices' => [
                      'Logement' => 'Choix 1',
                      'individuel Logement en bande '=> 'Choix 2',
                      'Duplex' => 'Choix 3',
                      'Appartement' => 'Choix 4'
                    // Ajoutez autant de choix que nécessaire
                ],
                'expanded' => true, // Cette option rendra les choix sous forme de boutons radio
            ])
            ->add('surfaceParcelle')
            ->add('surfaceHabitableMaison')
            ->add('estimationAchat', ChoiceType::class, [
                'choices' => [
                    '-30M ar à 30M ar' => 'valeur_1',
                    '30M ar à 50M ar' => 'valeur_2',
                    '50M ar à 100M ar' => 'valeur_3',
                    '100M ar à 200M ar' => 'valeur_4',
                    '200M ar à 300M ar' => 'valeur_5',
                    '300M ar à 400M ar' => 'valeur_6',
                    '400M ar à 500M ar' => 'valeur_7',
                    ' +500M ar' => 'valeur_8',
                    // Ajoutez autant de choix que nécessaire
                ],
                'placeholder' => 'choisissez une option', // Cette option rendra les choix sous forme de boutons radio
            ])
            ->add('modalitePaiement')
            ->add('banque', ChoiceType::class, [
                'choices' => [
                    'BOA' => 'valeur_1',
                    'BNI' => 'valeur_2',
                    'SOCIETE GENERALE' => 'valeur_3',
                    'BMOI' => 'valeur_4',
                    'MICROCREDIT' => 'valeur_5',
                    'Autres' => 'valeur_6',
                    // Ajoutez autant de choix que nécessaire
                ],
                'placeholder' => 'Choisissez une option',
            ])
            ->add('premierVersement', ChoiceType::class, [
                'label' => "Si à crédit,quel sera le 1er versement :",
                'choices' => [
                    '10%' => 'valeur_1',
                    '20%' => 'valeur_2',
                    '30%' => 'valeur_3',
                    '40%' => 'valeur_4',
                    '50%' => 'valeur_5',
                    
                    // Ajoutez autant de choix que nécessaire
                ],
                // Optionnel : définir le choix par défaut
                'placeholder' => 'Choisissez une option',
            ])            
            ->add('possibilitePaiementMensuel', ChoiceType::class, [
                'label' => "Quelle en sera votre possibilité de paiement mensuel :",
                'choices' => [
                    '150 000 ar à 300 000 ar' => 'valeur_1',
                    '300 000 ar à 600 000 ar' => 'valeur_2',
                    '600 000 ar à 1 200 000 ar' => 'valeur_3',
                    '+ de 2 000 000 ar' => 'valeur_4',

                    
                    // Ajoutez autant de choix que nécessaire
                ],
                // Optionnel : définir le choix par défaut
                'placeholder' => 'Choisissez une option',
            ])            
            ->add('acceptationTraitementDonnees', CheckboxType::class, [
                'label' => "J'accepte que mes données soient traitées par SEIMad, dans le cadre de ma demande et de la relation commerciale qui pourrait en découler",
    'required' => true, // Vous pouvez définir cette option sur true ou false en fonction de vos besoins
    'attr' => [
        // 'class' => 'custom-control-input', // Vous pouvez ajouter des classes CSS personnalisées si nécessaire
    ],
])
            
            ->add('Envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
