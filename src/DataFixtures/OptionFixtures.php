<?php

namespace App\DataFixtures;

use App\Entity\Immo;
use App\Entity\Option;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OptionFixtures extends Fixture
{
    const LIMIT = 120 ;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR") ;
        for($i = 0; $i < self::LIMIT; $i++) {
            $manager->persist((new Option())->setName($faker->words(1, true))) ;
        }

        $manager->flush();
    }
}
