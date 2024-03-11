<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('pseudo', TextType::class, [
                'required' => false,
                'attr'=> [
                'class'=> 'form-control'
            ]
        ])
            ->add('email', TextType::class, [
                'required' => false,
                'attr'=> [
                'class'=> 'form-control'
            ]
        ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class'=> 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('isSeller', CheckboxType::class, [
                'required' => false,
                'label' => 'Je suis vendeur',
                'mapped' => false, 
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
            ])
            ->add('raisonSociale', TextType::class, [
                'required' => false,
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            ->add('numeroSiret', TextType::class, [
                'required' => false,
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            ->add('description', TextType::class, [
                'required' => false,
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            ->add('adresse', TextType::class, [
                'required' => false,
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            ->add('ville', TextType::class, [
                'required' => false,
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            ->add('cp', NumberType::class, [
                'required' => false,
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            ->add('heureOuverture', TimeType::class, [
                'required' => false,
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            ->add('heureFermeture', TimeType::class, [
                'required' => false,
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            ->add('jourOuverture', TextType::class, [
                'required' => false,
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
          
            ;
    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
          
        ]);
    }
}
