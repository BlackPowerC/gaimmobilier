<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder ;

    public function __construct(UserPasswordEncoderInterface $enc) {
        $this->encoder = $enc ;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User() ;
        $user->setUsername("jojo") ;
        $pass = $this->encoder->encodePassword($user, "jojo") ;
        dump($pass) ;
        $user->setPassword($pass) ;

        $manager->persist($user) ;
        $manager->flush() ;
    }
}
