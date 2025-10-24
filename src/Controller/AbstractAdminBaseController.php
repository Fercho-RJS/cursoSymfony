<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbstractAdminBaseController extends AbstractController
{
  # Mensaje flash personalizado para "Información" #
  public function addFlashInfo(string $message): void
  {
    $this->addFlash('info', $message);
  }

  # Mensaje flash personalizado para "Éxito" #
  public function addFlashSuccess(string $message): void
  {
    $this->addFlash('success', $message);
  }

  # Mensaje flash personalizado para "Alerta" #
  public function addFlashWarning(string $message): void
  {
    $this->addFlash('warning', $message);
  }

  # Mensaje flash personalizado para "Error" #
  public function addFlashError(string $message): void
  {
    $this->addFlash('error', $message);
  }
}
