<?php

namespace App\Form;

use App\Entity\Evento;
use App\Entity\Disertante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EventoType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('titulo', TextType::class)
      ->add('descripcion', TextType::class)
      ->add('fecha', DateType::class, [
        'widget' => 'single_text',
        'html5' => true,
        'required' => true,
    ])
    ->add('hora', TimeType::class, [
        'widget' => 'single_text',
        'html5' => true,
        'required' => true,
    ]) 
      ->add('duracion', IntegerType::class)
      ->add('idioma', ChoiceType::class, [
        'choices' => [
          'Español' => 'es',
          'Inglés' => 'en',
        ],
      ])
      ->add('disertante', EntityType::class, [
        'class' => Disertante::class,
        'choice_label' => 'nombre',
        'required' => false,
        'query_builder' => function ($repositorio) {
          return $repositorio->createQueryBuilder('d')->orderBy('d.nombre', 'ASC');
        },
      ])
      ->add('submit', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class, [
    'label' => 'Guardar evento',
    'attr' => ['class' => 'btn btn-primary']
      ]);

  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Evento::class,
    ]);
  }
}
