<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($actorNumber = 0; $actorNumber < 10; $actorNumber++) {
            $actor = new Actor();
            $actor->setName($faker->firstName. ' ' . $faker->lastName);
            
            $programs = ProgramFixtures::DATAS;
            shuffle($programs);

            for($i = 0 ; $i < 3; $i++) {
                $actor->addProgram($this->getReference('program_' . $this->slugger->slug($programs[$i]['title'])->lower()));
            }

            $manager->persist($actor);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ActorFixtures dépend
        return [
        ProgramFixtures::class,
        ];
    }
}
