<?php

namespace App\Controller;

use App\Repository\EpisodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;

#[Route('/program', name: 'program_')]
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
    public function show(ProgramRepository $programRepository, int $id): Response
    {
        $program = $programRepository->findOneById($id);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table'
            );
        }
        $seasons = $program->getSeasons();

        return $this->render('program/show.html.twig', [
            'id' => $id,
            'program' => $program,
            'seasons' => $seasons
        ]);
    }

    #[Route('/{programId}/seasons/{seasonId}', name: 'season_show', requirements: ['id' => '\d+'])]
    public function showSeason(
        int $programId,
        int $seasonId,
        ProgramRepository $programRepository,
        EpisodeRepository $episodeRepository,
        SeasonRepository $seasonRepository
        ): Response {

        $program = $programRepository->findOneById($programId);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program found'
            );
        };

        $season = $seasonRepository->findOneById($seasonId);

        if (!$season) {
            throw $this->createNotFoundException(
                'No season found for ' . $program->getTitle()
            );
        };

        $episodes = $episodeRepository->findBySeason($seasonId);

        if (!$episodes) {
            throw $this->createNotFoundException(
                'No episodes found for ' . $season->getNumber() . ' of ' . $program->getTitle()
            );
        };

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes
        ]);
    }
}
