<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evento;
use DateTime;
use Symfony\Component\Validator\Constraints\Time;
use App\Repository;
use App\Repository\EventoRepository;

/**
 * @Route("/admin", name="app_admin")
 */
class AdminEventoController extends AbstractController
{
    /**
     * @Route("/evento", name="app_admin_evento")
     */
    public function index(): Response
    {
        return $this->render('admin_evento/index.html.twig', [
            'controller_name' => 'AdminEventoController',
        ]);
    }

    /**
     * @Route("/evento/listar", name="app_admin_evento_listar")
     */
    public function listarAction(): Response
    {
        $em = $this->getDoctrine()->getManager();

        // Consulta DQL directa usando EntityManager
        $dql = "SELECT e FROM App\Entity\Evento e ORDER BY e.titulo ASC";
        $query = $em->createQuery($dql);
        $eventos = $query->getResult();

        // var_dump($eventos);
        // exit();

        return $this->render('adminEvento/eventos.html.twig', [
            'eventos' => $eventos,
        ]);
    }
}
