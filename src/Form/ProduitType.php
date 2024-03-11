<?php

namespace App\Form;

use App\Entity\Produit;
use App\Form\ImageType;
use App\Entity\Commande;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            
            ->add('description', TextType::class, [
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])

            ->add('prix', MoneyType::class, [
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])

            ->add('images', FileType::class, [
                'label' => 'Image du produit',
                'attr' => ['class' => 'form-control'],
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new All ([
                        'constraints' => [
                            new File ([
                                'maxSize' => '15254k',
                                'mimeTypes' => [
                                    'image/jpeg',
                                    'image/png',
                                    'image/webp',                                  
                                    'image/jpg',
                                ],
                                'mimeTypesMessage' => 'Please upload une image valide',
                            ]),
                        ]                    
                    ])
                ],
            ])

           
            
            ->add('Valider', SubmitType::class, [
                'attr'=> [
                    'class' => 'btn btn-primary'
                ]
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
