<?php

namespace App\Form;

use App\Entity\FooterLinks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FooterLinksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Facebook, Instagram, ...',
                ],
            ])
            ->add('link', UrlType::class, [
                'label' => 'Lien',
                'attr' => [
                    'placeholder' => 'https://https://www.instagram.com/...',
                ],
            ])
            ->add('icon', TextType::class, [
                'label' => 'Icone',
                'attr' => [
                    'placeholder' => '<i class="fa-brands fa-instagram"></i>',
                ],
            ])
            ->add('visible', CheckboxType::class, [
                'label' => 'Afficher ? ',
                'required' => false,
                'attr' => [
                    'checked' => 'checked',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FooterLinks::class,
        ]);
    }
}
