<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Episode;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for($programNumber = 1; $programNumber <= 5; $programNumber++) {
            for($seasonNumber = 1; $seasonNumber <= 5; $seasonNumber++) {
                for($episodeNumber = 1; $episodeNumber <= 10; $episodeNumber++) {
                    $episode = new Episode();
                    $episode->setTitle($faker->word());
                    $episode->setNumber($episodeNumber);
                    $episode->setSynopsis($faker->paragraphs(3, true));
                    $episode->setSeason($this->getReference('season_' . $seasonNumber . '_program_' . $programNumber));
                    $manager->persist($episode);   
                }
            }
        }
        $manager->flush();
    }

    public function getDependencies()
{
    // Tu retournes ici toutes les classes de fixtures dont SeasonFixtures dépend
    return [
    SeasonFixtures::class,
    ];
    
}

}
