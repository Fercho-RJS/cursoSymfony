<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


// #[Route('/default', name: 'app_default')]
class DefaultController extends AbstractController
{
  /**
   * @Route("/", name="app_portada")
   */
  public function portadaAction()
  {
    $em = $this->getDoctrine()->getManager();

  }
}


