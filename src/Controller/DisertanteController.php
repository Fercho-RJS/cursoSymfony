<?php namespace App\Controller;

/* 
  RUTAS:
    /disertante                   --> app_disertante_inicio       Redirige al listado de disertantes
    /disertante/nuevo            --> app_disertante_nuevo        Crear nuevo disertante
    /disertante/listado          --> app_disertante_listado      Listar todos los disertantes
    /disertante/{id}             --> app_disertante_por_id       Ver detalle de un disertante por ID
*/

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use Symfony\Component\Validator\Constraints\Time;
use App\Repository;
use App\Entity\Disertante;
use App\Repository\DisertanteRepository;
use App\Form\DisertanteType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/disertante", name="app_disertante_")
 */
class DisertanteController extends AbstractController
{
  /**
   * @Route("", name="inicio")
   */
  public function index(): Response
  {
    return $this->redirectToRoute('app_disertante_listado');
  }

  // ---------------------------------- ## NUEVO ## ----------------------------------

  /**
   * @Route("/nuevo", name="nuevo")
   */
  public function nuevoDisertanteAction(Request $request, EntityManagerInterface $em): Response
  {
    $disertante = new Disertante();

    $form = $this->createForm(DisertanteType::class, $disertante);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($disertante);
      $em->flush();

      $this->addFlash('info', "El disertante '" . $disertante->getNombreCompleto() . "' se ha creado correctamente.");

      return $this->redirectToRoute('app_admin_disertante_listar');
    }

    return $this->render('adminDisertante/nuevo.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  // ---------------------------------- ## LISTADO ## ----------------------------------

  /**
   * @Route("/listado", name="listado")
   */
  public function listarDisertantes(DisertanteRepository $repository): Response
  {
    $disertantes = $repository->findAll();

    return $this->render('disertante/disertantes.html.twig', [
      'disertantes' => $disertantes,
    ]);
  }

  // ---------------------------------- ## BUSCAR POR ID ## ----------------------------------

  /**
   * @Route("/{id}", name="por_id")
   */
  public function disertantePorId($id, EntityManagerInterface $em): Response
  {
    // El siguiente método quedó obsoloto para ésta versión de symfony, se recomienda inyectarlo en la function directamente como parámetro. >>>
    // -----------------------------------------------------------------------------------------------
    // $em = $this->getDoctrine()->getManager();

    $disertante = $em->getRepository(Disertante::class)->findDisertanteConEventosPorId($id);

    if (!$disertante) {
      throw $this->createNotFoundException('Disertante no encontrado');
    }

    return $this->render('disertante/disertante.html.twig', [
      'disertante' => $disertante
    ]);
  }
}
