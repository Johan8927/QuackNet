<?php

namespace App\Repository;

use App\Entity\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comments>
 */
class CommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comments::class);
    }

        /**
        * @return Comments[] Returns an array of Comments objects
       */
        public function findAll(): array
        {
            return $this->createQueryBuilder('c')
                ->orderBy('c.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

        /**
        * @return Comments[] Returns an array of Comments objects
        */
        public function findByParentId($parentId): array
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.parentId = :parentId')
                ->setParameter('parentId', $parentId)
                ->getQuery()
                ->getResult()
            ;
        }

        /**
        * @return Comments[] Returns an array of Comments objects
        */
        public function findByResponse($isResponse): array
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.isResponse = :isResponse')
                ->setParameter('isResponse', $isResponse)
                ->getQuery()
                ->getResult()
            ;
        }
        public function findByExampleField($value): array
        {
           return $this->createQueryBuilder('c')
               ->andWhere('c.exampleField = :val')
               ->setParameter('val', $value)
                ->orderBy('c.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult();

        }

        public function findOneBySomeField($value): ?Comments
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.exampleField = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }

}
