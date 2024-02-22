<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('newPhotos', CollectionType::class, [
                'label' => false,
                'entry_type' => MultiplePhotoType::class,
                'allow_add' => true,
                'mapped' => false, // This field is not mapped to the entity
                'by_reference' => false,
                'prototype' => true,
                'required' => false,
                'entry_options' => [
                    'label' => false,
                    // ...
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
