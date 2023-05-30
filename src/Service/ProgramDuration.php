<?php

namespace App\Service;

use App\Entity\Program;
use App\Repository\ProgramRepository;
use App\Entity\Episode;
use App\Entity\Season;
use App\Repository\EpisodeRepository;

class ProgramDuration {

    // private Episode $episode;
    
    // private Season $season;

    public function calculate(Program $program, EpisodeRepository $episodeRepository): string
    {   
      $seasons = $program->getSeasons();
      $episodes = $episodeRepository->findbySeason();

        return 'coming soon'; 
    }
    
}