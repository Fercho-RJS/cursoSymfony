<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbstractAdminBaseController extends AbstractController
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
