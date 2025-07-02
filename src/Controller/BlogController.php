<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog', name: 'app_blog')]
class BlogController extends AbstractController
{
    #[Route('/', name: 'app_blog')]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    #[Route('/view/{id}', name: 'view_post')]
    public function verPost($id): Response
    {
        return new Response('Al usuario le corresponde el ID: ' . $id);
    }

    #[Route('/create/{data}', name: 'create_post')]
    public function createUser($data): Response
    {
        return new Response('El usuario: ' . $data . ' ha sido creado con éxito.');
    }

    #[Route('/update/{id}', name: 'update_post')]
    public function updateUser($id): Response
    {
        return new Response('El ID: ' . $id . ' ha sido modificado con éxito.');
    }
}
