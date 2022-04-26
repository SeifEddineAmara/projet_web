<?php

namespace App\Form;

use App\Search\TypeDeMusiqueSearchData;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchTypeDeMusiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Genre', TextType::class,[
                'required' => false,
                'attr' => [
                    'placeholder' => 'Genre'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeDeMusiqueSearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);

    }

    public function getBlockPrefix()
    {
        return '';
    }

}