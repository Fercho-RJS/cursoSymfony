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
   * @Route("/nuevo", name="nuevo")
   */
  public function nuevoDisertanteAction(Request $request, EntityManagerInterface $em): Response
  {
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Doctrine\ORM\EntityManagerInterface;
    use App\Entity\Disertante;
    use App\Form\DisertanteType;
    
    $disertante = new Disertante();

    $form = $this->createForm(DisertanteType::class, $disertante);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($disertante);
      $em->flush();

      $this->addFlash('info', "El disertante '" . $disertante->getNombreCompleto() . "' se ha creado correctamente.");

      return $this->redirectToRoute('app_admin_disertante_listar');
    }

    return $this->render('admin_disertante/nuevo.html.twig', [
      'form' => $form->createView(),
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
   * @Route("/disertante/{id}", name="app_disertante_por_id")
   */
  public function detallePorSlug($id): Response
  {
    $em = $this->getDoctrine()->getManager();
    $disertante = $em->getRepository(Disertante::class)->findDisertanteConEventosPorId($id);

    if (!$disertante) {
      throw $this->createNotFoundException('Disertante no encontrado');
    }

    return $this->render('disertante/disertante.html.twig', [
      'disertante' => $disertante
    ]);
  }
}
