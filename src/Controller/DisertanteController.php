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
use Symfony\Component\HttpFoundation\Request;

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

        return $this->render('disertante/disertantes.html.twig', [
            'disertantes' => $disertantes
        ]);
    }

    /**
     * @Route("/disertante/{id}", name="app_disertante_por_id")
     */
    public function detalle($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $disertante = $em->getRepository(Disertante::class)->find($id);

        if (!$disertante) {
            throw $this->createNotFoundException('Disertante no encontrado');
        }

        return $this->render('disertante/disertante.html.twig', [
            'disertante' => $disertante
        ]);
    }
    /**
     * @Route("/disertante/slug/{slug}", name="app_disertante_por_slug")
     */
    public function detallePorSlug($slug): Response
    {
        $em = $this->getDoctrine()->getManager();
        $disertante = $em->getRepository(Disertante::class)->findDisertanteConEventosPorSlug($slug);

        if (!$disertante) {
            throw $this->createNotFoundException('Disertante no encontrado');
        }

        return $this->render('disertante/disertante.html.twig', [
            'disertante' => $disertante
        ]);
    }
}
