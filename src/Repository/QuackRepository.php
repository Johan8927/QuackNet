<?php

namespace App\Repository;

namespace App\Repository;

use App\Entity\Quack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class QuackRepository extends ServiceEntityRepository
{


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quack::class);
    }


    public function findAll(): array
    {
        return $this->createQueryBuilder('q')
            ->orderBy('q.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}