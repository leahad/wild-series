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

  public function calculate($program) {

    $programDuration = $this->programRepository->calculProgramDuration($program);
    return $programDuration;

  }
    
}