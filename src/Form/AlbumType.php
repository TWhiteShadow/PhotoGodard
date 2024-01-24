<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Photo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('password')
            // ->add('photos', EntityType::class, [
            //     'class' => Photo::class,
            //     'choice_label' => 'filename',
            //     'multiple' => true,
            //     'required' => false,
            // ])
            ->add('newPhotos', CollectionType::class, [
                'label' => false,
                'entry_type' => AlbumPhotoType::class,
                'allow_add' => true,
                'mapped' => false, // This field is not mapped to the entity
                'prototype' => true,
                'entry_options' => array(
                    'label' => false,
                    // ...
                ),
            ]);
                
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
