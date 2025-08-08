<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evento;
use DateTime;
use Symfony\Component\Validator\Constraints\Time;

class EventoController extends AbstractController
{
    /**
     * @Route("/evento", name="app_evento")
     */
    public function index(): Response
    {
        return $this->render('evento/index.html.twig', [
            'controller_name' => 'EventoController',
        ]);
    }

    /**
     * @Route("/evento/new", name="app_evento_new")
     */
    public function newAction(): Response
    {
        $evento = new Evento;

        //Hidratado
        $evento -> setTitulo('Introducción al Symfony 5');
        $evento -> setDuracion(20);
        $evento -> setIdioma('Español (Argentina)');
        $evento -> setDescripcion('Aguante River');

        //em = entity manager > $em = $this -> getDoctrine() -> getManager();

        $em = $this -> getDoctrine() -> getManager();

        //Persistimos el objeto en la BDD.
        $em -> persist($evento); //Lo manda al $em
        $em -> flush(); //

        // dump($evento);
        exit;
        return $this->render('evento/index.html.twig', [
            'controller_name' => 'EventoController',
        ]);
    }
}
