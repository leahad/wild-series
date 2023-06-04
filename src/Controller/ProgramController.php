<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Program;
use App\Entity\Episode;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\ActorRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use App\Service\ProgramDuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function new(Request $request, ProgramRepository $programRepository, SluggerInterface $slugger): Response
    {
        $program = new program();

        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
        $slug = $slugger->slug($program->getTitle());
        $program->setSlug($slug);
        $programRepository->save($program, true); 

        $this->addFlash('success', 'The new program has been created');

        return $this->redirectToRoute('program_index');
    }

    return $this->render('program/new.html.twig', [
        'form' => $form,
    ]);
    }

    #[Route('/show/{slug}', methods: ['GET'], name: 'show')]
    public function show($slug,Program $program, ProgramDuration $programDuration): Response
    {

        if (!$program) {
        throw $this->createNotFoundException(
            'No program with id : '.$program.' found in program\'s table.'
        );
    }
    return $this->render('program/show.html.twig', [
        'program' => $program,
        // 'programDuration' => $programDuration->calculate($program),
        'slug' => $slug,
    ]);
    }

    #[Route('/show/{slug}/edit', methods: ['GET', 'POST'], name: 'edit')]
    public function edit(Request $request, Program $program, ProgramRepository $programRepository, SluggerInterface $slugger, $slug): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);
            $programRepository->save($program, true);

            $this->addFlash('success', 'The program has been edited');

            return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('program/edit.html.twig', [
            'program' => $program,
            'form' => $form,
            'slug'=>$slug,
        ]);
    }

    #[Route('/show/{slug}', methods: ['POST'], name: 'delete')]
    public function delete(Request $request, Program $program, programRepository $programRepository, $slug): Response
    {
        if ($this->isCsrfTokenValid('delete'.$program->getId(), $request->request->get('_token'))) {
            $programRepository->remove($program, true);
            $this->addFlash('danger', 'The program has been deleted');
        }

        return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{slug}/seasons/{season}', methods: ['GET'], name: 'season_show')]
    public function showSeason(Program $program, Season $season, EpisodeRepository $episodeRepository, $slug): Response
    {
        $episodes = $episodeRepository->findBy(['season' => $season]);

        if (!$season) {
        throw $this->createNotFoundException(
            'No season with id : '.$season.' found in season\'s table.'
        );
    }
    return $this->render('program/season_show.html.twig', [
        'program' => $program,
        'slug'=> $slug,
        'season' => $season,
        'episodes' => $episodes,
    ]);
    }

    #[Route('/{slug}/seasons/{season}/episode/{episode}', methods: ['GET'], name: 'episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode, $slug): Response
    {
        if (!$episode) {
        throw $this->createNotFoundException(
            'No season with id : '.$episode.' found in season\'s table.'
        );
    }
    return $this->render('program/episode_show.html.twig', [
        'program' => $program,
        'slug'=> $slug,
        'season' => $season,
        'episode' => $episode,
    ]);
    }

}