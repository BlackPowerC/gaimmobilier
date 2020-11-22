<?php

namespace App\DataFixtures;

use App\Entity\Immo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ImmoFixtures extends Fixture
{
    const LIMIT = 120 ;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR") ;
        for($i = 0; $i < self::LIMIT; $i++)
        {
            $immo = (new Immo())->setTitle($faker->words(3, true))
                ->setRooms($faker->numberBetween(2, 20))
                ->setDescription($faker->sentence( 255, true))
                ->setBedrooms($faker->numberBetween(1, 20))
                ->setSurface($faker->numberBetween(15, 60))
                ->setFloor($faker->numberBetween(1, 20))
                ->setHeat($faker->numberBetween(0, 1))
                ->setPrice($faker->numberBetween(25000, 45000))
                ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setPostalCode($faker->postcode);

            $manager->persist($immo) ;
        }

        $manager->flush();
    }
}
