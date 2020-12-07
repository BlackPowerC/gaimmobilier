<?php

namespace App\Repository;

use LogicException;
use Pagerfanta\Pagerfanta;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\PagerfantaInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class PageableRepository extends ServiceEntityRepository
{
    public function paginate(QueryBuilder $qb, int $limit = 20, int $offset = 0) : PagerfantaInterface
    {
        if($offset < 0 OR $limit < 1) {
            throw new LogicException("limit must be greater than 1 or offset must be greater than 0") ;
        }

        $pager = new Pagerfanta(new QueryAdapter($qb)) ;
        $pager->setCurrentPage($offset + 1) ;
        $pager->setMaxPerPage($limit) ;

        return $pager ;
    }
}