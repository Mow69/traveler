<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Destination;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DestinationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('longitude')
//            ->add('latitude')
            ->add('city', TextType::class, [
                'label' => 'City arrival',
                'label_attr' => [
                    'class' => 'pr-3'
                ]
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
                'label' => 'Country arrival'
            ])
            ->add('Submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Destination::class,
        ]);
    }
}
