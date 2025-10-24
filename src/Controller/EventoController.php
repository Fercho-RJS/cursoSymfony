<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evento;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/evento", name="app_evento_")
 */
class EventoController extends AbstractController
{
  // -------------------------- ## [ INICIO ] ## -------------------------------------

  /**
   * @Route("", name="inicio")
   */
  public function index(): Response
  {
    return $this->redirectToRoute('app_evento_listado');
  }

  // -------------------------- ## [  BUSCAR POR SLUG  ] ## --------------------------

  /**
   * @Route("/buscar/{slug}", name="por_slug")
   */
  public function eventoAction(string $slug, EntityManagerInterface $em): Response
  {
    $evento = $em->getRepository(Evento::class)->findEventoConDisertantePorSlug($slug);

    if (!$evento) {
      throw $this->createNotFoundException('Evento no encontrado');
    }

    //Mensaje flash de acceso a evento.
    $this->addFlash('info', 'Has accedido al evento: ' . $evento->getTitulo() . ' a las ' . (new \DateTime())->format('H:i:s') . ' del día ' . (new \DateTime())->format('d/m/Y'));


    return $this->render('evento/evento.html.twig', [
      'evento' => $evento,
      'disertante' => $evento->getDisertante(),
    ]);
  }

  // -------------------------- ## [  LISTAR TODOS LOS EVENTOS DISPONIBLES  ] ## ---------------------

  /**
   * @Route("/listado", name="listado")
   */
  public function eventosAction(EntityManagerInterface $em): Response
  {
    $eventos = $em->getRepository(Evento::class)->findEventosAlfabeticamente();

    $this->addFlash('info', '<b>Has listado todos los eventos</b> a las ' . (new \DateTime())->format('H:i:s') . ' del día ' . (new \DateTime())->format('d/m/Y'));

    return $this->render('evento/eventos.html.twig', [
      'eventos' => $eventos,
    ]);
  }

  /**
   * @Route("/buscar/disertante/{slug}", name="_disertante_por_slug")
   */
  public function disertantePorSlugAction(string $slug, EntityManagerInterface $em): Response
  {
    $evento = $em->getRepository(Evento::class)->findOneBy(['slug' => $slug]);

    if (!$evento || !$evento->getDisertante()) {
      throw $this->createNotFoundException('No existe el disertante para el evento solicitado...');
    }

    return $this->render('evento/disertante.html.twig', [
      'disertante' => $evento->getDisertante(),
    ]);
  }

  // -------------------------- ## [  NUEVO (PRUEBA)  ] ## --------------------------

  /**
   * @Route("/nuevo/prueba", name="nuevo")
   */
  // public function newAction(): Response
  // {
  //   $evento = new Evento();
  //   $evento->setTitulo('Introducción al Symfony 5');
  //   $evento->setDuracion(20);
  //   $evento->setIdioma('Español (Argentina)');
  //   $evento->setDescripcion('Aguante River');

  //   $em = $this->getDoctrine()->getManager();
  //   $em->persist($evento);
  //   $em->flush();

  //   return new Response('Evento creado con ID: ' . $evento->getId());
  // }
}
