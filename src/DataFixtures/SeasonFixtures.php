<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Season;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{ 
    public function __construct(private SluggerInterface $slugger) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach(ProgramFixtures::DATAS as $data) {
            for ($i = 1; $i <= 5; $i++) {
                $season = new Season();

                $season->setNumber($i);
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraphs(3, true));
                $program = $this->slugger->slug($data['title'])->lower();
                $season->setProgram($this->getReference('program_' . $program));

                $manager->persist($season);
                $this->addReference('season_' . $i . '_program_' . $program, $season);
            }
        }
        $manager->flush();
    }

public function getDependencies()
{
    // Tu retournes ici toutes les classes de fixtures dont SeasonFixtures dépend
    return [
    ProgramFixtures::class,
    ];

}

}
