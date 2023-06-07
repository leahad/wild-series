<?php

namespace App\Service;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\season;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Proxies\__CG__\App\Entity\Season as EntitySeason;

class ProgramDuration {

  private ProgramRepository $programRepository;

  public function __construct(programRepository $programRepository)
  {
    $this->programRepository = $programRepository;
  }

  public function calculate(Program $program) {

    $seasons = $program->getSeasons();
    $total = 0;
    foreach($seasons as $season) {
      $episodes = $season->getEpisodes();
        foreach($episodes as $episode) {
          $total += $episode->getDuration(); 
      }  
    }
    // $day = $total/60/24;
    // $hour = $day%60;
    // return $day .''. $hour;
    return $total . 'minutes';
  }
    
}