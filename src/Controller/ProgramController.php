<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Request;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render(
            'program/index.html.twig', 
            ['programs' => $programs]
        );
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $program = new Program();

        $form = $this->createForm(ProgramType::class, $program);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $programRepository->add($program, true);

            return $this->redirectToRoute('program_index');
        }

        return $this->renderForm('program/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/show/{id<^[0-9]+$>}', name: 'show')]    
    public function show( Program $program, SeasonRepository $seasonRepository): Response
    {
        $season = $seasonRepository->findByProgram($program);
        if (!$program) {
                throw $this->createNotFoundException(
                    'No program with id : '.$id. ' found in program\'s table.'
                );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $season
         ]);
    }

    #[Route('/{programId<^[0-9]+$>}/seasons/{seasonId<^[0-9]+$>}', name: 'season_show')]
    public function showSeason( Program $programId, Season $seasonId, EpisodeRepository $episodeRepository): Response
    {   
        $episodes = $episodeRepository->findBySeason($seasonId);
        if (!$programId) {
            throw $this->createNotFoundException(
                'No program with id : '.$programId. ' found in program\'s table.'
            );
        }
        if (!$seasonId) {
            throw $this->createNotFoundException(
                'No season with id : '.$seasonId. ' found in season\'s table.'
            );
        }
        return $this->render('program/season_show.html.twig', [
            'program' => $programId,
            'season' => $seasonId,
            'episodes' => $episodes
         ]);
    }

    #[Route('/{programId<^[0-9]+$>}/seasons/{seasonId<^[0-9]+$>}/episode/{episodeId<^[0-9]+$>}', name: 'episode_show')]
    public function showEpisode( Program $programId, Season $seasonId, Episode $episodeId): Response
    {   
        if (!$programId) {
            throw $this->createNotFoundException(
                'No program with id : '.$programId. ' found in program\'s table.'
            );
        }
        if (!$seasonId) {
            throw $this->createNotFoundException(
                'No season with id : '.$seasonId. ' found in season\'s table.'
            );
        }
        if (!$episodeId) {
            throw $this->createNotFoundException(
                'No episode with id : '.$episodeId. ' found in episode\'s table.'
            );
        }
        return $this->render('program/episode_show.html.twig', [
            'program' => $programId,
            'season' => $seasonId,
            'episode' => $episodeId
         ]);
    }
}