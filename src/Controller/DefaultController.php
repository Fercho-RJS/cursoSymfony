<?php namespace App\Controller;

/* 
  RUTAS:
    /portada                      --> app_portada           Muestra la portada con eventos aleatorios
    /consulta                     --> app_consulta          Formulario de contacto/consulta
    /consulta_metodo_viejo        --> app_consulta_vieja    Versión anterior del formulario (comentado)
    /condiciones                  --> app_estatica          Página estática de condiciones (comentado)
*/

use App\Entity\Evento;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use App\Entity\Consulta;
use App\Form\ConsultaType;

class DefaultController extends AbstractController
{
  // ---------------------------------- ## PORTADA ## ----------------------------------

  /**
   * @Route("/portada", name="app_portada")
   */
  public function portada(EntityManagerInterface $em): Response
  {
    $eventos = $em->getRepository(Evento::class)->findAll();

    $total = count($eventos); //Sacamos la cuenta de cuántos eventos existen en la BDD.
    $eventos_tomados = min($total, 8); //Toma solo 8 eventos, si son más de 8, solo tomará 8.
    $listEventSelected = [];

    while (count($listEventSelected) < $eventos_tomados) //Mientras $eventosCol no tenga registros cargamos los mismos, hasta llenar 8 filas como máximo.
    {
      $evento = $eventos[rand(0, $total - 1)]; //Seleccionamos un evento al azar de todos los leidos.
      if (!in_array($evento, $listEventSelected, true)) {
        //Guardamos en nuestra columna de eventos, el evento tomado al azar.
        $listEventSelected[] = $evento;
      }
    }

    return $this->render('default/portada.html.twig', [
      'eventosCol1' => array_slice($listEventSelected, 0, 4),
      'eventosCol2' => array_slice($listEventSelected, 4, 4),
    ]);
  }

  // ---------------------------------- ## CONSULTA ## ----------------------------------

  /**
   * @Route("/consulta", name="app_consulta")
   */
  public function consulta(Request $request, EntityManagerInterface $em): Response
  {
    $consulta = new Consulta();

    $form = $this->createForm(ConsultaType::class, $consulta);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($consulta);
      $em->flush();

      $this->addFlash('info', '¡Gracias por su consulta! En breve nos pondremos en contacto con usted.');
      return $this->redirectToRoute('app_portada');
    }

    return $this->render('default/consulta.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  // ---------------------------------- ## BASURERO ## ----------------------------------

  /**
   * @Route("/consulta_metodo_viejo", name="app_consulta_vieja")
   */
  // public function consultaVieja(Request $request, EntityManagerInterface $em): Response
  // {
  //   $defaultData = ['consulta' => 'Escriba aquí su consulta ...'];

  //   $collectionConstraints = new Collection([
  //     'fields' => [
  //       'nombre' => new Length(['min' => 3]),
  //       'email' => new Email(['message' => 'Dirección de email inválida']),
  //       'consulta' => new Length(['min' => 5]),
  //     ],
  //     'allowExtraFields' => true,
  //   ]);

  //   $form = $this->createFormBuilder($defaultData, ['constraints' => $collectionConstraints])
  //     ->add('nombre', TextType::class)
  //     ->add('mail', EmailType::class)
  //     ->add('consulta', TextareaType::class)
  //     ->add('Enviar', SubmitType::class)
  //     ->getForm();

  //   $form->handleRequest($request);

  //   if ($form->isSubmitted() && $form->isValid()) {
  //     $em->persist($consulta);
  //     $em->flush();

  //     $this->addFlash('info', '¡Gracias por su consulta! En breve nos pondremos en contacto con usted.');
  //     return $this->redirectToRoute('app_portada');
  //   }

  //   return $this->render('default/consulta.html.twig', [
  //     'form' => $form->createView(),
  //   ]);
  // }

  // ---------------------------------- ## CONDICIONES ## ----------------------------------

  /**
   * @Route("/condiciones", name="app_estatica", defaults={"pagina"="condiciones"})
   */
  // public function estatica(): Response
  // {
  //   return $this->render('static/condiciones.html.twig');
  // }
}
