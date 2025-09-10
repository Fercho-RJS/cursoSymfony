<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use DateTime;
use Symfony\Component\Validator\Constraints\Time;
use App\Repository;
use App\Entity;
use App\Repository\EventoRepository;
use App\Repository\DisertanteRepository;
use App\Repository\UsuarioRepository;

// El objetivo de crear estas clases controladoras propias es extender las funcionalidades de la
// clase Controller de Symfony, con nuestras propias funcionalidades y características
// (funcionalidades correspondiente a la capa del controlador, atajos, etc.).

// Crear en las clases AbstractBaseControler y AbstractAdminBaseControler un conjunto de
// métodos que permita agregar mensajes flash del tipo informativo, de advertencias y de error
// (mensajes del frontend y del backend respectivamente). Estos métodos deben ser utilizados
// en todos los controladores de la aplicación en lugar de la forma tradicional de agregar un
// mensaje flash.


class AbstractBaseController extends AbstractController
{
    
}
