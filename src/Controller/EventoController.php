<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evento;
use DateTime;

class EventoController extends AbstractController
{
    /**
     * @Route("/evento", name="app_render_eventos")
     */
    public function index(): Response
    {
        return $this->render('evento/eventos.html.twig', [
            'controller_name' => 'EventoController',
        ]);
    }

    /**
     * @Route("/evento/{slug}", name="app_evento")
     */
    public function eventoAction(Request $request, string $slug): Response
    {
        $em = $this->getDoctrine()->getManager();
        $evento = $em->getRepository(Evento::class)->findEventoConDisertantePorSlug($slug);

        if (!$evento) {
            throw $this->createNotFoundException('Evento no encontrado');
        }

        return $this->render('evento/evento.html.twig', [
            'evento' => $evento,
            'disertante' => $evento->getDisertante()
        ]);
    }

    /**
     * @Route("/eventos", name="app_eventos")
     */
    public function eventosAction(): Response
    {
        $eventos = $this->getDoctrine()
            ->getRepository(Evento::class)
            ->findEventosAlfabeticamente();

        return $this->render('evento/eventos.html.twig', [
            'eventos' => $eventos,
        ]);
    }

    /**
     * @Route("/evento/new", name="app_evento_new")
     */
    public function newAction(): Response
    {
        $evento = new Evento();
        $evento->setTitulo('Introducción al Symfony 5');
        $evento->setDuracion(20);
        $evento->setIdioma('Español (Argentina)');
        $evento->setDescripcion('Aguante River');

        $em = $this->getDoctrine()->getManager();
        $em->persist($evento);
        $em->flush();

        return new Response('Evento creado con ID: ' . $evento->getId());
    }

    /**
     * @Route("/evento/disertante/{slug}", name="app_disertante_by_slug")
     */
    public function disertanteBySlugAction(string $slug): Response
    {
        $evento = $this->getDoctrine()
            ->getRepository(Evento::class)
            ->findOneBy(['slug' => $slug]);

        if (!$evento || !$evento->getDisertante()) {
            throw $this->createNotFoundException('No existe el disertante para el evento solicitado...');
        }

        return $this->render('evento/disertante.html.twig', [
            'disertante' => $evento->getDisertante(),
        ]);
    }
}
