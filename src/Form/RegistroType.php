<?php namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegistroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class)
            ->add('apellidos', TextType::class)
            ->add('dni', TextType::class)
            ->add('direccion', TextType::class)
            ->add('telefono', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Contraseña'],
                'second_options' => ['label' => 'Repetir Contraseña'],
            ])
            ->add('submit', SubmitType::class, [
            'label' => 'Registrarse',
            'attr' => ['class' => 'btn btn-primary']
        ]);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'registro';
    }
}
