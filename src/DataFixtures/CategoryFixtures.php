<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
const CATEGORIES = [
'Adventure',
'Animated',
'Comedy',
'Drama',
'Documentary',
'Crime',
'Horror',
'Romcom',
'SF',
];

public function load(ObjectManager $manager)
{
    foreach(self::CATEGORIES as $categoryName) {
        $category = new Category();
        $category->setName($categoryName);
        $manager->persist($category);
        $this->addReference('category_' . $categoryName, $category);
    }
    $manager->flush();

    }
}
