<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use Symfony\Component\Validator\Constraints\Time;
use App\Repository;
use App\Entity\Disertante;
use App\Repository\DisertanteRepository;

class DisertanteController extends AbstractController
{
    /**
     * @Route("/disertante", name="app_disertante")
     */
    public function index(): Response
    {
        return $this->render('disertante/disertante.html.twig', [
            'controller_name' => 'DisertanteController',
        ]);
    }

    /**
     * @Route("/disertantes", name="app_disertantes")
     */
    public function disertantesAction(): Response
    {
        // Obtener el EntityManager
        $em = $this->getDoctrine()->getManager();
        $disertantes = $em->getRepository(Disertante::class)->findDisertantesAlfabeticamente();

        return $this->render('disertante/disertante.html.twig', [
            'disertantes' => $disertantes
        ]);

        // return('ruta/de/la/planilla' , ['datoNombre' => $variableDatoNombre])
    }
}
