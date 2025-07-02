<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sitio", name="app_site")
 */
class EstaticaController extends AbstractController
{
    /**
     * @Route(
     *     "/{pagina}",
     *     name="app_redirigir",
     *     requirements={"pagina"="patrocinadores|licencia|condiciones|privacidad"}
     * )
     */
    
    public function estaticaAction($pagina = 'patrocinadores'){
        return $this -> render('static/' . $pagina . '.html.twig');
    }   
}
