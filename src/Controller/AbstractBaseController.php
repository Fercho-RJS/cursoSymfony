<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function addFlashInfo(string $message)
    {
        return $this->addFlash('info', $message);
    }

    public function addFlashWarning(string $message)
    {
        return $this->addFlash('warning', $message);
    }

    public function addFlashError(string $message)
    {
        return $this->addFlash('error', $message);
    }
}
