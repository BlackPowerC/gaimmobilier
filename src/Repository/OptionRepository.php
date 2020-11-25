<?php

namespace App\Repository;

use App\Entity\Option;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Option|null find($id, $lockMode = null, $lockVersion = null)
 * @method Option|null findOneBy(array $criteria, array $orderBy = null)
 * @method Option[]    findAll()
 * @method Option[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionRepository extends ServiceEntityRepository
{

    private $em ;

    public function __construct(EntityManagerInterface $em, ManagerRegistry $registry) 
    {
        parent::__construct($registry, Option::class);
        $this->em = $em ;
    }

    public function findAllQuery()
    {
        $dql = "SELECT o FROM App\Entity\Option o" ;
        return $this->em->createQuery($dql) ;
    }
    
}
