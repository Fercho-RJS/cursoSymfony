<?php namespace App\Controller;

/* 
  RUTAS:
    /admin/disertante                  --> app_admin_disertante             (opcional, aún no definida)
    /admin/disertante/listado         --> app_admin_disertante_listado     Listar todos los disertantes
    /admin/disertante/nuevo           --> app_admin_disertante_nuevo       Crear nuevo disertante
    /admin/disertante/{id}/editar     --> app_admin_disertante_editar      Editar disertante por ID
    /admin/disertante/{id}/eliminar   --> app_admin_disertante_borrar      Eliminar disertante por ID
*/

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Disertante;
use App\Form\DisertanteType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DisertanteRepository;

/**
 * @Route("/admin/disertante", name="app_admin_disertante_")
 */
class AdminDisertanteController extends AbstractController
{
  /**
   * @Route("/{id}/editar", name="editar")
   */
  public function editarDisertanteAction(int $id, Request $request, EntityManagerInterface $em): Response
  {
    $disertante = $em->getRepository(Disertante::class)->find($id);

    if (!$disertante) {
      throw $this->createNotFoundException('Disertante no encontrado');
    }

    $form = $this->createForm(DisertanteType::class, $disertante); //Creación del formulario.

    $form->handleRequest($request); //Recibimos las repuestas.

    if ($form->isSubmitted() && $form->isValid()) {
      $em->flush();

      $this->addFlash('success', "El disertante '" . $disertante->getNombreCompleto() . "' se ha actualizado correctamente.");

      return $this->redirectToRoute('app_admin_disertante_listado');
    }

    return $this->render('adminDisertante/editar.html.twig', [
      'form' => $form->createView(),
      'disertante' => $disertante,
    ]);
  }

  /**
   * @Route("/nuevo", name="nuevo")
   */
  public function nuevoDisertanteAction(Request $request): Response
  {
    $disertante = new Disertante();
    $disertante->setNombre('Nombre del disertante');
    $disertante->setEmail('email@ejemplo.com');
    $disertante->setBiografia('Biografía del disertante');

    $form = $this->createForm(DisertanteType::class, $disertante);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($disertante);
      $em->flush();

      $this->addFlash('info', "El disertante '" . $disertante->getNombre() . "' se ha creado correctamente.");

      return $this->redirectToRoute('app_admin_disertante_listado');
    }

    return $this->render('adminDisertante/nuevo.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/listado", name="listado")
   */
  public function listadoDisertantes(DisertanteRepository $repository): Response
  {

    $disertantes = $repository->findAll();

    return $this->render('adminDisertante/listado.html.twig', [
      'disertantes' => $disertantes,
    ]);
  }

  /**
   * @Route("/{id}/eliminar", name="borrar")
   */
  public function eliminarDisertanteAction(int $id, EntityManagerInterface $em): Response
  {
    $disertante = $em->getRepository(Disertante::class)->find($id);

    if (!$disertante) {
      throw $this->createNotFoundException('Disertante no encontrado');
    }

    $em->remove($disertante);
    $em->flush();

    $this->addFlash('success', "El disertante '" . $disertante->getNombreCompleto() . "' se ha eliminado correctamente.");

    return $this->redirectToRoute('app_admin_disertante_listado');
  }
}
