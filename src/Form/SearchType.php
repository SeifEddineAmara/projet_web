<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Artiste;
use App\Entity\Restaurant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => false,
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('artiste', EntityType::class, [
                'class'=> Artiste::class,
                'choice_label' => 'nomArtiste',
                'required' => false
            ])
            ->add('restaurant',EntityType::class, [
                'class' => Restaurant::class,
                'choice_label' => 'nom',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => SearchData::class,
           'method' => 'GET',
           'csrf_protection' => false
        ]);

    }

    public function getBlockPrefix()
    {
        return '';
    }
}