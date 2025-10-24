<?php namespace App\Controller;

/* 
  RUTAS:
    /patrocinadores               --> app_estatica     Página estática de patrocinadores
    /licencia                     --> app_estatica     Página estática de licencia
    /condiciones                  --> app_estatica     Página estática de condiciones
    /privacidad                   --> app_estatica     Página estática de privacidad
*/

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class EstaticaController extends AbstractController
{
    /**
     * @Route(
     *     "/{pagina}",
     *     name="app_estatica",
     *     requirements={"pagina"="patrocinadores|licencia|condiciones|privacidad"}
     * )
     */
    public function estaticaAction(Request $request) : Response{
        $pagina = $request->attributes->get('pagina', 'patrocinadores');

        return $this->render('static/' . $pagina . '.html.twig');
    }
}
