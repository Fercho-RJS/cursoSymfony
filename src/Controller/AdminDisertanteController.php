<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/disertante", name="app_admin_disertante_")
 */
class AdminDisertanteController extends AbstractController
{
  /**
   * @Route("/nuevo", name="nuevo")
   */
  public function nuevoDisertanteAction(): Response {
    $disertante = new Disertante();
    $disertante->setNombre('Nombre del disertante');
    $disertante->setEmail('email@ejemplo.com');
    $disertante->setBiografia('Biografía del disertante');
    

    $form = $this->createForm(EventoType::class, $disertante);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($disertante);
      $em->flush();

      $this->addFlash('info', "El disertante '" . $disertante->getNombre() . "' se ha creado correctamente.");

      return $this->redirectToRoute('app_disertantes');
    }

    return $this->render('adminEvento/nuevo.html.twig', [
      'form' => $form->createView(),
    ]);
  }
}
