<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;

#[Route('/program', name:'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('program/index.html.twig', [
            'programs' => $programs,   
        ]);
    }

    #[Route('/{id}', methods: ['GET'], name: 'show', requirements: ['id' => '\d+'])]
    public function show(ProgramRepository $programRepository,int $id): Response
    {
        $program = $programRepository->findOneById($id);

        if(!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table'
            );
        }

        return $this->render('program/show.html.twig', [
            'id' => $id,
            'program' => $program
        ]);

    }
}
