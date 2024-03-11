<?php

namespace App\Form;

use App\Entity\PointRelais;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PointRelaisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            ->add('adresse', TextType::class, [
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            ->add('ville', TextType::class, [
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
            ->add('Valider', SubmitType::class, [
                'attr'=> [
                    'class' => 'btn btn-primary'
                ]
            ] );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PointRelais::class,
        ]);
    }
}
