<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evento;
use DateTime;
use Symfony\Component\Validator\Constraints\Time;
use App\Repository;

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
    public function eventoAction($slug) //: Response
    {
        $em = $this->getDoctrine()->getManager();
        $evento = $em->getRepository(Evento::class)->findOneBy(['slug' => $slug]);

        if (!$evento) {
            throw $this->createNotFoundException('No existe el evento solicitado...');
        } else {
            return $this->render('evento/evento.html.twig', [
                'evento' => $evento
            ]);
        }
    }

    /**
     * @Route("/eventos", name="app_eventos")
     */
    public function eventosAction(): Response
    {
        // Obtener el EntityManager
        $em = $this->getDoctrine()->getManager();

        $eventos = $em->getRepository(Evento::class)->findEventosAlfabeticamente();

        return $this->render('evento/eventos.html.twig', [
            'eventos' => $eventos
        ]);

        // return('ruta/de/la/planilla' , ['datoNombre' => $variableDatoNombre])
    }

    /**
     * @Route("/evento/new", name="app_evento_new")
     */
    public function newAction(): Response
    {
        $evento = new Evento;

        //Hidratado
        $evento->setTitulo('Introducción al Symfony 5');
        $evento->setDuracion(20);
        $evento->setIdioma('Español (Argentina)');
        $evento->setDescripcion('Aguante River');

        //em = entity manager > $em = $this -> getDoctrine() -> getManager();

        $em = $this->getDoctrine()->getManager();

        //Persistimos el objeto en la BDD.
        $em->persist($evento); //Lo manda al $em
        $em->flush(); //

        // dump($evento);
        exit;
        return $this->render('evento/index.html.twig', [
            'controller_name' => 'EventoController',
        ]);
    }
}
