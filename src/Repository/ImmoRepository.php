<?php

namespace App\Repository;

use App\Entity\Immo;
use App\Entity\ImmoSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
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
     * @param ImmoSearch $search
     * @return array
     */
    public function findAllUnSoldedQuery(ImmoSearch $search) : ?QueryBuilder
    {
        $query = $this->findAllSoldedOrUnSolded(false) ;
        if($search->getMaxPrice())
        {
            $query->where("i.price <= :maxPrice") ;
            $query->setParameter("maxPrice", $search->getMaxPrice()) ;
        }
        if($search->getMinSurface())
        {
            $query->where("i.surface >= :minSurface") ;
            $query->setParameter("minSurface", $search->getMinSurface()) ;
        }
        return $query ;
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
        return $this->createQueryBuilder('i')
            ->where("i.sold = :sold")
            ->setParameter("sold", $status) ;
    }

}
