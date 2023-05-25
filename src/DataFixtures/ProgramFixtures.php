<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Program;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
const PROGRAMS = [
    ['title' => 'Stranger Things', 'synopsis' => 'Stranger Things is set in the fictional rural town of Hawkins, Indiana, in the 1980s.', 'category' => 'SF'],
    ['title' => 'The Haunting of the Hill House', 'synopsis' => 'The plot alternates between two timelines, following five adult siblings whose paranormal experiences at Hill House continue to haunt them in the present day, and flashbacks depicting events leading up to the eventful night in 1992 when the family fled from the mansion.', 'category' => 'Horror'],
    ['title' => 'Games of Thrones', 'synopsis' => 'The plot revolves around two continents namely, Westeros (the western continent) and Essos (the eastern continent). Noble families of Westeros fight amongst themselves to gain the Iron Throne. And, meanwhile an old enemy which has been dormant for ages is rising again.', 'category' => 'SF'],
    ['title' => 'Euphoria', 'synopsis' => 'Euphoria follows teenagers in the fictional town of East Highland, California, who seek hope while balancing the strains of love, loss, and addiction.', 'category' => 'Drama'],
    ['title' => 'Final Space', 'synopsis' => 'The series involves an astronaut named Gary Goodspeed and his immensely powerful alien friend Mooncake, and focuses on their intergalactic adventures as they try to save the universe from certain doom.', 'category' => 'Animated'],
];

    public function load(ObjectManager $manager): void
    {
        foreach(self::PROGRAMS as $program => $column) { 
        $program = new Program();
        $program->setTitle($column['title']);
        $program->setSynopsis($column['synopsis']);
        $program->setCategory($this->getReference('category_' . $column['category']));
        $manager->persist($program);
        $this->addReference('program_' . $column['title'], $program);
    }
    $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
        CategoryFixtures::class,
        ];
    }

}
