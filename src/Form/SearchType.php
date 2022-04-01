<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('regions', ChoiceType::class, [
            //     'attr' => [
            //         'class' => 'js-get-regions'
            //     ],
            //     'mapped' => false,
            //     "help" => "Ne fonctionne pas."
            // ])
            ->add('ville', ChoiceType::class, [
                'attr' => [
                    'class' => 'js-get-cities'
                ],
                'mapped' => false,
                
            ])
        ;
        // $builder->get('regions')->resetViewTransformers();
        $builder->get('ville')->resetViewTransformers();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
