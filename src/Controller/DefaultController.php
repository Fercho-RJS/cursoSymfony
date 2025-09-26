<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evento;
use App\Entity\Consulta;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends AbstractBaseController
{
  /**
   * @Route("/portada", name="app_portada")
   */
  public function portadaAction()
  {
    // Obtener el EntityManager
    $em = $this->getDoctrine()->getManager();
    // Obtener el repositorio de Articulo
    $eventoRepository = $em->getRepository(Evento::class);
    // Obtener todos los eventos
    $eventos = $eventoRepository->findAll();

    $total = count($eventos);
    $n = ($total >= 8) ? 8 : ($total < 8 && $total > 0) ? $total : 0;
    $eventosCol = $eventosCol1 = $eventosCol2 = array();
    for ($i = 0; $i < $n; $i++) {
      $evento = $eventos[\rand(0, $total - 1)];
      while (in_array($evento, $eventosCol)) {
        $evento = $eventos[\rand(0, $total - 1)];
      }
      $eventosCol[] = $evento;
    }

    return $this->render('default/portada.html.twig', array(
      'eventosCol1' => array_slice($eventosCol, 0, 4),
      'eventosCol2' => array_slice($eventosCol, 4, 4)
    ));
  }

  /**
   * @Route("/condiciones", name="app_estatica", defaults={"pagina"="condiciones"});
   */
  public function estaticaAction()
  {
    return $this->render('static/condiciones.html.twig');
  }

  /**
   * @Route("/consulta", name="app_consulta")
   */
  public function consultaAction(Request $request)
  {
    // Vincular el formulario a la entidad Consulta
    $consulta = new Consulta();

    $form = $this->createFormBuilder($consulta)
      ->add('nombre', TextType::class)
      ->add('mail', EmailType::class)
      ->add('consulta', TextareaType::class)
      ->add('Enviar', SubmitType::class)
      ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      // Persistir la consulta en base de datos
      $em = $this->getDoctrine()->getManager();
      $em->persist($consulta);
      $em->flush();

      $this->addFlashInfo('¡Gracias por su consulta! En breve nos pondremos en contacto con usted.');
      return $this->redirect($this->generateUrl('app_portada'));
    }

    return $this->render(
      'default/consulta.html.twig',
      array(
        'form' => $form->createView(),
      )
    );
  }
}
