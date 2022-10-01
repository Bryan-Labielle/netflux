<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name:'app_')]
class DefaultController extends AbstractController
{
    #[Route('index', name:'index')]
    public function index(): Response
    {
        return $this->render('program/base.html.twig', [
            'test' => 'Ceci est un test'
        ]);
    }
}