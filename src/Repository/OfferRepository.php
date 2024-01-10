<?php

namespace App\Repository;

use App\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Collection;

/**
 * @extends ServiceEntityRepository<Offer>
 *
 * @method Offer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offer[]    findAll()
 * @method Offer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    public function findMatchingCriteria(Collection $offerCollection): array
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->leftJoin('o.criteria', 'c');

        $counter = 0;
        foreach ($offerCollection as $offers) {
            $queryBuilder
                ->andWhere("o.name = :name$counter")
                ->andWhere("o.description = :description$counter")
                ->andWhere("o.assignment = :assignment$counter")
                ->andWhere("o.collaborator = :collaborator$counter")
                ->andWhere("o.minSalary = :minSalary$counter")
                ->andWhere("o.maxSalary = :maxSalary$counter")
                ->andWhere("o.contractType = :contractTypey$counter")
                ->andWhere("o.remote = :remote$counter")
                ->setParameter("name$counter", $offers->getName())
                ->setParameter("description$counter", $offers->getDescription())
                ->setParameter("assignment$counter", $offers->getassignment())
                ->setParameter("collaborator$counter", $offers->getcollaborator())
                ->setParameter("minSalary$counter", $offers->getminSalary())
                ->setParameter("maxSalary$counter", $offers->getmaxSalary())
                ->setParameter("contractType$counter", $offers->getcontractType())
                ->setParameter("remote$counter", $offers->getRemote());

            $counter++;
        }
        return $queryBuilder->getQuery()->getResult();
    }

//    /**
//     * @return Offer[] Returns an array of Offer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Offer
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
