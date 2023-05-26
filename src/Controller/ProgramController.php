<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Episode;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
            'programs'=> $programs
            ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $program = new program();

        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
        $programRepository->save($program, true); 
        return $this->redirectToRoute('program_index');
    }

    return $this->render('program/new.html.twig', [
        'form' => $form,
    ]);
    }

    #[Route('/show/{id<\d+>}', methods: ['GET'], name: 'show')]
    public function show(Program $program, SeasonRepository $seasonRepository): Response
    {
        $seasons = $seasonRepository->findBy(['program' => $program]);

        if (!$program) {
        throw $this->createNotFoundException(
            'No program with id : '.$program.' found in program\'s table.'
        );
    }
    return $this->render('program/show.html.twig', [
        'program' => $program,
        'seasons' => $seasons,
    ]);
    }

    #[Route('/{program}/seasons/{season}', methods: ['GET'], name: 'season_show')]
    public function showSeason(Program $program, Season $season, EpisodeRepository $episodeRepository): Response
    {
        $episodes = $episodeRepository->findBy(['season' => $season]);

        if (!$season) {
        throw $this->createNotFoundException(
            'No season with id : '.$season.' found in season\'s table.'
        );
    }
    return $this->render('program/season_show.html.twig', [
        'program' => $program,
        'season' => $season,
        'episodes' => $episodes,
    ]);
    }

    #[Route('/{program}/seasons/{season}/episode/{episode}', methods: ['GET'], name: 'episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        if (!$episode) {
        throw $this->createNotFoundException(
            'No season with id : '.$episode.' found in season\'s table.'
        );
    }
    return $this->render('program/episode_show.html.twig', [
        'program' => $program,
        'season' => $season,
        'episode' => $episode,
    ]);
    }

}