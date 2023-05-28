<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();

            for($actorNumber = 1; $actorNumber <= 10; $actorNumber++) {
                for($programNumber = 1; $programNumber <= 3; $programNumber++) {
                $actor = new Actor();
                $firstName = $faker->firstName;
                $lastName = $faker->lastName;
                $actor->setName($firstName . ' ' . $lastName);
                $actor->addProgram($this->getReference('program_' . $faker->randomNumber(1,5)));
                }
                $manager->persist($actor);
                $this->addReference('actor_' . $faker->randomNumber(1,10), $actor);
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
