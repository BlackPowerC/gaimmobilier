<?php

namespace App\Repository;

use App\Entity\Immo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Immo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Immo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Immo[]    findAll()
 * @method Immo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImmoRepository extends ServiceEntityRepository
{
    private $em ;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Immo::class);
        $this->em = $em ;
    }

    /**
     * Trouver tout les biens immobiliers non-vendus
     *
     * @return array
     */
    public function findAllUnSolded() : array {
        return $this->findAllSoldedOrUnSolded(false) ;

    }

    /**
     * Trouver tout les biens immobiliers vendus
     *
     * @return array
     */
    public function findAllSolded() : array {
        return $this->findAllSoldedOrUnSolded(true) ;
    }

    private function findAllSoldedOrUnSolded(bool $status)
    {
        return $this->em->createQuery("SELECT i FROM App\Entity\Immo i WHERE i.sold = :sold")
            ->setParameter("sold", $status)
            ->getResult();
    }

}
