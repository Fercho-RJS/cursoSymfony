<?php

namespace App\Form;

use App\Entity\Disertante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DisertanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class)
            ->add('apellidos', TextType::class)
            ->add('email', TextType::class)
            ->add('telefono', TextType::class)
            ->add('direccion', TextType::class)
            ->add('biografia', TextType::class)
            ->add('url', TextType::class, ['required' => false])
            ->add('twitter', TextType::class, ['required' => false])
            ->add('linkedin', TextType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disertante::class,
        ]);
    }
}
