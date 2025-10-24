<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\RegistroType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @Route("/usuario", name="app_usuario_")
 */
class UsuarioController extends AbstractController
{
  /**
   * @Route("/registro", name="registro")
   */
  // ------------------------------------------------------------------------------------
  //                                MÉTODO CON REGISTRO TYPE
  // ------------------------------------------------------------------------------------
  public function registro(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
  {
    $usuario = new Usuario();

    $form = $this->createForm(RegistroType::class, $usuario);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      // Codificar la contraseña
      $hashedPassword = $passwordHasher->hashPassword($usuario, $usuario->getPassword());
      $usuario->setPassword($hashedPassword);

      // Guardar en la base de datos
      $em->persist($usuario);
      $em->flush();

      // Mensaje de éxito
      $this->addFlash('info', '¡Gracias por registrarte! Tu cuenta ha sido activada.');

      return $this->redirectToRoute('app_portada');
    }

    return $this->render('usuario/registro.html.twig', [
      'form' => $form->createView(),
    ]);
  }


  // ------------------------------------------------------------------------------------
  //                                MÉTODO VIEJO
  // ------------------------------------------------------------------------------------
  // public function registro(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
  // {
  //   $usuario = new Usuario();

  //   $form = $this->createForm(RegistroType::class, $usuario);
  //   $form->add('submit', SubmitType::class, [
  //     'label' => 'Regístrate',
  //     'attr' => ['class' => 'btn btn-primary']
  //   ]);

  //   $form->handleRequest($request);

  //   if ($form->isSubmitted() && $form->isValid()) {
  //     // Codificar la contraseña
  //     $hashedPassword = $passwordHasher->hashPassword($usuario, $usuario->getPassword());
  //     $usuario->setPassword($hashedPassword);

  //     // Guardar en la base de datos
  //     $em->persist($usuario);
  //     $em->flush();

  //     // Mensaje de éxito
  //     $this->addFlash('info', '¡Gracias por registrarte! Tu cuenta ha sido activada.');

  //     return $this->redirectToRoute('app_portada');
  //   }

  //   return $this->render('usuario/registro.html.twig', [
  //     'form' => $form->createView(),
  //   ]);
  // }
}
