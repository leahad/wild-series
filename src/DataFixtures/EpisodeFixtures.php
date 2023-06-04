<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Episode;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach(ProgramFixtures::DATAS as $data) {
            for($seasonNumber = 1; $seasonNumber <= 5; $seasonNumber++) {
                $program = $this->slugger->slug($data['title'])->lower();
                $season = $this->getReference('season_' . $seasonNumber . '_program_' . $program);

                for($episodeNumber = 1; $episodeNumber <= 10; $episodeNumber++) {
                        $episode = new Episode();
                        $episode = $episode->setTitle($faker->sentence(3));
                        $episode->setNumber($episodeNumber);
                        $episode->setDuration($faker->randomNumber(2,true));
                        $episode->setSynopsis($faker->paragraphs(3, true));
                        $episode->setSeason($season);
                        $episode->setSlug($this->slugger->slug($episode->getTitle())->lower());
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
