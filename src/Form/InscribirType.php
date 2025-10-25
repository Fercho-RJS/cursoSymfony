<?php

namespace App\Form;

use App\Entity\Evento;
use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscripcionType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('evento', EntityType::class, [
        'class' => Evento::class,
        'choice_label' => 'titulo',
        'label' => 'Evento',
        'required' => true,
      ])
      ->add('usuario', EntityType::class, [
        'class' => Usuario::class,
        'choice_label' => 'email', // o 'nombreCompleto' si lo tenés
        'label' => 'Usuario',
        'required' => true,
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => null,
    ]);
  }
}
