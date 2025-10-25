<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Consulta;
use App\Repository\ConsultaRepository;

/**
   * @Route("/admin/consulta", name="app_admin_consulta_")
   */
class AdminConsultaController extends AbstractController
{
  /**
   * @Route("/ver", name="ver_consultas")
   */
  public function listadoConsultas(ConsultaRepository $repository): Response
  {
    $consultas = $repository->findBy([], ['fecha' => 'DESC']); // Ordenadas por fecha descendente

    return $this->render('adminConsulta/consultas.html.twig', [
      'consultas' => $consultas,
    ]);
  }
}
