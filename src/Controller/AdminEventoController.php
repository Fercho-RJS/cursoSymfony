<?php namespace App\Controller;

/* 
  RUTAS:
    /admin/evento                --> app_admin_evento
    /admin/evento/listar         --> app_admin_evento_listar
    /admin/evento/inscriptos/{id}--> app_admin_evento_inscriptos
    /admin/evento/borrar/{id}    --> app_admin_evento_borrar
    /admin/evento/nuevo          --> app_admin_evento_nuevo
    /admin/evento/{id}/editar    --> app_admin_evento_editar
*/

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evento;
use DateTime;
use Symfony\Component\Validator\Constraints\Time;
use App\Repository;
use App\Repository\EventoRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\AbstractAdminBaseController;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EventoType;

/**
 * @Route("/admin", name="app_admin_")
 */
class AdminEventoController extends AbstractAdminBaseController
{
  /**
   * @Route("/evento", name="evento")
   */
  public function index(): Response
  {
    return $this->render('admin_evento/index.html.twig', [
      'controller_name' => 'AdminEventoController',
    ]);
  }

  /**
   * @Route("/evento/listar", name="evento_listar")
   */
  public function listarAction(EntityManagerInterface $em): Response
  {
    // Consulta DQL directa usando EntityManager
    // ---------------------------------------------------------------------------------------------
    //$dql = "SELECT e FROM App\Entity\Evento e ORDER BY e.titulo ASC";
    // ---------------------------------------------------------------------------------------------

    // Consulta DQL directa usando EntityManager con optimización de carga de usuarios.
    // ---------------------------------------------------------------------------------------------
    // $dql = "SELECT e, u FROM App\Entity\Evento e LEFT JOIN e.usuarios u ORDER BY e.titulo ASC";
    // $query = $em->createQuery($dql);
    // $eventos = $query->getResult();
    // ---------------------------------------------------------------------------------------------
    

    $eventos = $em->getRepository(Evento::class)->findEventosAlfabeticamente();
    // -------------------------------------- ## TEST ## -------------------------------------------
    // Probamos que se reciba el listado de eventos de forma correcta.
    // ---------------------------------------------------------------------------------------------
    // var_dump($eventos);
    // exit();
    // ---------------------------------------------------------------------------------------------
    
    return $this->render('adminEvento/eventos.html.twig', [
      'eventos' => $eventos
    ]);
  }

  /**
   * @Route("/evento/inscriptos/{id}", name="evento_inscriptos")
   */
  public function inscriptosAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    // Buscar el evento por ID
    $evento = $em->getRepository(Evento::class)->find($id);

    if (!$evento) {
      throw $this->createNotFoundException('Evento no encontrado');
    }

    return $this->render('adminEvento/inscriptos.html.twig', [
      'evento' => $evento
    ]);
  }

  //--------------------  [[# BORRAR #]] --------------------

  /**
   * @Route("/evento/borrar/{id}", name="evento_borrar")
   */
  public function borrarAction($id) 
  {
    $em = $this->getDoctrine()->getManager();

    // Buscar el evento por ID
    $evento = $em->getRepository(Evento::class)->find($id);

    if (!$evento) {
      throw $this->createNotFoundException('Evento no encontrado');
    }

    $em->remove($evento);
    $em->flush();


    // Mensaje flash con método Symfony
    // ---------------------------------------------------------------------------------------------
    // $this->addFlash('info', 'El evento fue eliminado correctamente: ' . $evento->getTitulo());

    // Mensaje flash mediante la función de AbstractAdminBaseController.
    // ---------------------------------------------------------------------------------------------
    $this->addFlashInfo('El evento fue eliminado correctamente: ' . $evento->getTitulo());

    return $this->redirectToRoute('app_admin_evento_listar');
  }

  //--------------------  [[# CREAR #]] --------------------

  /**
   * @Route("/evento/nuevo", name="evento_nuevo")
   */
  public function nuevoAction(Request $request, EntityManagerInterface $em): Response
  {
    // Nuevo objeto "Evento" que luego se flusheará a la base de datos.
    $evento = new Evento();

    // Valores por defecto que tomará el formulario.
    $evento->setFecha(new \DateTime('now'));
    $evento->setHora(new \DateTime('now'));
    $evento->setDuracion(2);

    // Generamos el formulario, elevando los datos preestablecidos anteriormente.
    $form = $this->createForm(EventoType::class, $evento);

    // Tomamos los datos enviados del formulario y los procesamos.
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($evento);
      // (!) > persist(); añade una nueva entidad al contexto de persistencia para que sea guardada en el futuro, sin ejecutar una consulta SQL inmediata.

      $em->flush();
      // (!) > flush(); sincroniza todos los cambios pendientes (incluyendo los recién persistidos) con la base de datos, ejecutando directamente las consultas SQL correspondientes.

      // Método original utilizado en ésta función para elevar un mensaje flash.
      // ---------------------------------------------------------------------------------------------
      // $this->addFlash('info', "El evento '" . $evento->getTitulo() . "' se ha creado correctamente.");

      // Método nuevo:
      $this->addFlashInfo('El evento "' . $evento->getTitulo() . '" fue creado correctamente');
      
      return $this->redirectToRoute('app_admin_evento_listar');
    }

    return $this->render('adminEvento/nuevo.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  //--------------------  [[# EDITAR #]] --------------------

  /**
   * @Route("/evento/{id}/editar", name="evento_editar")
   */
  public function editarAction(int $id, Request $request, EntityManagerInterface $em): Response
  {
    $evento = $em->getRepository(Evento::class)->find($id);

    if (!$evento) {
      throw $this->createNotFoundException('No existe el evento solicitado.');
    }

    $form = $this->createForm(EventoType::class, $evento);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->flush();

      $this->addFlash('info', 'El evento "' . $evento->getTitulo() . '" se ha modificado correctamente.');

      return $this->redirectToRoute('app_admin_evento_listar');
    }

    return $this->render('adminEvento/editar.html.twig', [
      'form' => $form->createView(),
      'evento' => $evento,
    ]);
  }
}
