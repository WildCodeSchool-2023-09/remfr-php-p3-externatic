<?php

namespace App\Repository;

use App\Entity\Criteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Collection;

/**
 * @extends ServiceEntityRepository<Criteria>
 *
 * @method Criteria|null find($id, $lockMode = null, $lockVersion = null)
 * @method Criteria|null findOneBy(array $criteria, array $orderBy = null)
 * @method Criteria[]    findAll()
 * @method Criteria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CriteriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Criteria::class);
    }

    public function findMatchingOffers(Collection $criteriaCollection): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
        ->leftJoin('c.offers', 'o');

        $counter = 0;
        foreach ($criteriaCollection as $criteria) {
            $queryBuilder
            ->andWhere("c.salary = :salary$counter")
            ->andWhere("c.profil = :profil$counter")
            ->andWhere("c.contract = :contract$counter")
            ->andWhere("c.location = :location$counter")
            ->andWhere("c.remote = :remote$counter")
            ->setParameter("salary$counter", $criteria->getSalary())
            ->setParameter("profil$counter", $criteria->getProfil())
            ->setParameter("contract$counter", $criteria->getContract())
            ->setParameter("location$counter", $criteria->getLocation())
            ->setParameter("remote$counter", $criteria->getRemote());

            $counter++;
        }
        return $queryBuilder->getQuery()->getResult();
    }

//    /**
//     * @return Criteria[] Returns an array of Criteria objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Criteria
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
