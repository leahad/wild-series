<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Season;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{ 
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for($programNumber = 1; $programNumber <= 5; $programNumber++) { 
            for($seasonNumber = 1; $seasonNumber <= 5; $seasonNumber++) { 
                $season = new Season();
                $season->setNumber($seasonNumber);
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraphs(3, true));
                $season->setProgram($this->getReference('program_' . $programNumber));
                $manager->persist($season);
                $this->addReference('season_' . $seasonNumber . '_program_' . $programNumber, $season);
            }
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
