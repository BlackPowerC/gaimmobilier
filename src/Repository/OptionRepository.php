<?php

namespace App\Repository;

use LogicException;
use App\Entity\Option;
use Pagerfanta\PagerfantaInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Option|null find($id, $lockMode = null, $lockVersion = null)
 * @method Option|null findOneBy(array $criteria, array $orderBy = null)
 * @method Option[]    findAll()
 * @method Option[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionRepository extends PageableRepository
{
    private $em ;

    public function __construct(EntityManagerInterface $em, ManagerRegistry $registry) 
    {
        parent::__construct($registry, Option::class);
        $this->em = $em ;
    }

    public function findAllQuery() {
        return $this->createQueryBuilder("o")->select()->orderBy("o.id", "desc") ;
    }
    
    /**
     * Récupérer toute les options mais en paginant
     *
     * @param integer $offset Le numéro de page à partir de zéro
     * @param integer $limit Le nombre maximal d'options à récupérer
     * @return PagerfantaInterface
     */
    public function findWithPagination(int $offset = 0, int $limit = 12) : PagerfantaInterface
    {
        if($offset < 0 OR $limit < 1) {
            throw new LogicException("limit must be greater than 1 or offset must be greater than 0") ;
        }

        return $this->paginate($this->findAllQuery(), $limit, $offset) ;
    }
}
