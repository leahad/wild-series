<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Episode;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    const EPISODES = [
        ['season' => '1', 'title' => 'Chapter One: The Vanishing of Will Byers', 'number' => '1', 'synopsis' =>'At the U.S. Dept. of Energy an unexplained event occurs. Then when a young Dungeons and Dragons playing boy named Will disappears after a night with his friends, his mother Joyce and the town of Hawkins are plunged into darkness.'],
        ['season' => '1', 'title' => 'Chapter Two: The Weirdo on Maple Street', 'number' => '2', 'synopsis' =>'Mike hides the mysterious girl in his house. Joyce gets a strange phone call.'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach(self::EPISODES as $episode => $column) { 
            $episode = new Episode();
            $episode->setTitle($column['title']);
            $episode->setNumber($column['number']);
            $episode->setSynopsis($column['synopsis']);
            $episode->setSeason($this->getReference('season_' . $column['season']));
            $manager->persist($episode);   
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
