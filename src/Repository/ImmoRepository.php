<?php

namespace App\Repository;

use App\Entity\Immo;
use App\Entity\ImmoSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
    public function findAllUnSoldedQuery(?ImmoSearch $search) : ?QueryBuilder
    {
        $query = $this->findAllSoldedOrUnSolded(false) ;
        if(!is_null($search))
        {
            if($search->getMaxPrice())
        {
            $query->andWhere("i.price <= :maxPrice") ;
            $query->setParameter("maxPrice", $search->getMaxPrice()) ;
        }
        if($search->getMinSurface())
        {
            $query->andWhere("i.surface >= :minSurface") ;
            $query->setParameter("minSurface", $search->getMinSurface()) ;
        }
        if(!$search->getOptions()->isEmpty())
        {
            $options = $search->getOptions() ;
            $index = 0 ;
            foreach($options as $option)
            {
                $query->andWhere(":option$index MEMBER OF i.options") ;
                $query->setParameter("option$index", $option) ;
                $index++ ;
            }
        }
        }

        return $query ;
    }

    /**
     * Trouver tout les biens immobiliers vendus
     *
     * @return array
     */
    public function findAllSolded() : ?QueryBuilder {
        return $this->findAllSoldedOrUnSolded(true) ;
    }

    private function findAllSoldedOrUnSolded(bool $status)
    {
        return $this->createQueryBuilder('i')
            ->where("i.sold = :sold")
            ->leftJoin("i.options", "opts")
            ->setParameter("sold", $status) ;
    }

}
