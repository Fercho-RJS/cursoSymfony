<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Entity\Consulta;
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

class DefaultController extends AbstractController
{
  /**
   * @Route("/portada", name="app_portada")
   */
  public function portada(EntityManagerInterface $em): Response
  {
    $eventos = $em->getRepository(Evento::class)->findAll();

    $total = count($eventos);
    $n = min($total, 8);
    $eventosCol = [];

    while (count($eventosCol) < $n) {
      $evento = $eventos[rand(0, $total - 1)];
      if (!in_array($evento, $eventosCol, true)) {
        $eventosCol[] = $evento;
      }
    }

    return $this->render('default/portada.html.twig', [
      'eventosCol1' => array_slice($eventosCol, 0, 4),
      'eventosCol2' => array_slice($eventosCol, 4, 4),
    ]);
  }

  /**
   * @Route("/condiciones", name="app_estatica", defaults={"pagina"="condiciones"})
   */
  public function estatica(): Response
  {
    return $this->render('static/condiciones.html.twig');
  }

  /**
   * @Route("/consulta", name="app_consulta")
   */
  public function consulta(Request $request, EntityManagerInterface $em): Response
  {
    $defaultData = ['consulta' => 'Escriba aquí su consulta ...'];

    $collectionConstraints = new Collection([
      'fields' => [
        'nombre' => new Length(['min' => 3]),
        'email' => new Email(['message' => 'Dirección de email inválida']),
        'consulta' => new Length(['min' => 5]),
      ],
      'allowExtraFields' => true,
    ]);

    $form = $this->createFormBuilder($defaultData, ['constraints' => $collectionConstraints])
      ->add('nombre', TextType::class)
      ->add('mail', EmailType::class)
      ->add('consulta', TextareaType::class)
      ->add('Enviar', SubmitType::class)
      ->getForm();

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
}
