<?php

namespace App\Form;

use App\Entity\Homepage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomepageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('photoTopLeft', FileType::class, ['data_class' => null, 'label' => 'Photo En-haut', 'attr' => ['placeholder' => 'Choisissez un fichier']])
            ->add('photoMiddle', FileType::class, ['data_class' => null, 'label' => 'Photo Milieu'])
            ->add('photoBottom', FileType::class, ['data_class' => null, 'label' => 'Photo En-bas'])
            ->add('title', null, ['label' => 'Titre du site', 'attr' => ['placeholder' => 'ex: Emmanuel Godard']])
            ->add('subtitle', null, ['label' => '2nd Titre du site', 'attr' => ['placeholder' => 'ex: Photographe passionné']])
            ->add('pfp', FileType::class, ['data_class' => null, 'label' => 'Photo de profil'])
            ->add('descriptionTitle', null, ['label' => 'Titre de description', 'attr' => ['placeholder' => 'ex: Emmanuel Godard']])
            ->add('descriptionText', TextareaType::class, ['label' => 'Texte de description', 'attr' => ['placeholder' => 'ex: Artiste français passionné de ...', 'rows' => 5]])
            ->add('contactDescription', TextareaType::class, ['label' => 'Texte de contact', 'attr' => ['placeholder' => 'ex: Vous pouvez me contacter...', 'rows' => 5]])
            ->add('contactNumber', null, ['label' => 'Numéro de téléphone', 'attr' => ['placeholder' => 'ex: +33 6 12 34 56 78']])
            ->add('contactLocation', null, ['label'=> 'Localisation professionnelle', 'attr' => ['placeholder' => 'ex: 13 rue du ...']])
            ->add('contactEmail', null, ['label' => 'Email de contact', 'attr' => ['placeholder' => 'ex: emmanuel.godard83@orange.fr']])
            ->add('contactPhotoTopRight', FileType::class, ['data_class' => null, 'label' => 'Contact Photo En-haut Droit'])
            ->add('contactPhotoBottomRight', FileType::class, ['data_class' => null, 'label' => 'Contact Photo En-bas Droit'])
            ->add('contactPhotoBottomLeft', FileType::class, ['data_class' => null, 'label' => 'Contact Photo En-bas Gauche'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Homepage::class,
        ]);
    }
}
