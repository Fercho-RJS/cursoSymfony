<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evento;
use DateTime;
use Symfony\Component\Validator\Constraints\Time;
use App\Repository;
use App\Repository\EventoRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\AbstractAdminBaseController;


/* 
Attempted to call an undefined method named "addFlashInfo" of class "App\Controller\AdminEventoController".

*/

/**
 * @Route("/admin")
 */
class AdminEventoController extends AbstractAdminBaseController
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
        //$dql = "SELECT e FROM App\Entity\Evento e ORDER BY e.titulo ASC";
        //Ahora DQL optimizado
        // $dql = "SELECT e, u FROM App\Entity\Evento e LEFT JOIN e.usuarios u ORDER BY e.titulo ASC";
        // $query = $em->createQuery($dql);
        // $eventos = $query->getResult();
        
        $eventos = $em->getRepository(Evento::class)->findEventosAlfabeticamente();

        // var_dump($eventos);
        // exit();

        

        return $this->render('adminEvento/eventos.html.twig', [
            'eventos' => $eventos
        ]);
    }

    /**
     * @Route("/evento/inscriptos/{id}", name="app_admin_evento_inscriptos")
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

    //Acá crearemos las acciones para eliminar el evento a partir del slug.
    /**
     * @Route("/evento/borrar/{id}", name="app_admin_evento_borrar")
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


        //Retornamos la plantilla con el mensaje flash.
        // $this->addFlash('info', 'El evento fue eliminado correctamente: ' . $evento->getTitulo());
        //Ahora usamos la función creada en AbstractAdminBaseController.
        $this->addFlashInfo('El evento fue eliminado correctamente: ' . $evento->getTitulo());

        return $this->redirectToRoute('app_admin_evento_listar');
    }
}
