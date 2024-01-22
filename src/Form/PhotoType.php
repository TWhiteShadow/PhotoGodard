<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Category;
use App\Entity\Photo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('imageFile', VichImageType::class, [
                'label' => 'Photo',
            ])
            ->add('album', EntityType::class, [
                'class' => Album::class,
            'choice_label' => 'name',
            'required' => false,
            ])
            
            ->add('categories', EntityType::class, [
                'class' => Category::class,
'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
