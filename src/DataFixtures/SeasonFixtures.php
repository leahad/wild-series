<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Season;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASONS = [
        ['program' => 'Stranger Things', 'number' => '1', 'year' => '2016', 'description' =>'On November 6, 1983 in Hawkins, Indiana, a scientist is attacked by an unseen creature at a U.S. government laboratory. 12-year-old Will Byers encounters the creature and mysteriously vanishes.'],
        ['program' => 'Stranger Things', 'number' => '2', 'year' => '2017', 'description' =>'In the fall of 1984, one year after his disappearance, Will Byers finds himself the target of the Upside Down.'],
    ];
    
    public function load(ObjectManager $manager): void
    {
        foreach(self::SEASONS as $season => $column) { 
        $season = new Season();
        $season->setNumber($column['number']);
        $season->setYear($column['year']);
        $season->setDescription($column['description']);
        $season->setProgram($this->getReference('program_' . $column['program']));
        $manager->persist($season);
        $this->addReference('season_' . $column['number'], $season);
    }
    $manager->flush();
}

public function getDependencies()
{
    // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
    return [
    ProgramFixtures::class,
    ];

}

}
