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
        $orConditions = $queryBuilder->expr()->orX();

        foreach ($offerCollection as $criteria) {
            $orConditions->add(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('o.name', ":name$counter"),
                    $queryBuilder->expr()->eq('o.description', ":description$counter"),
                    $queryBuilder->expr()->gte('o.assignment', ":assignment$counter"),
                    $queryBuilder->expr()->eq('o.collaborator', ":collaborator$counter"),
                    $queryBuilder->expr()->gte('o.minSalary', ":minSalary$counter"),
                    $queryBuilder->expr()->lte('o.maxSalary', ":maxSalary$counter"),
                    $queryBuilder->expr()->eq('o.contractType', ":contractType$counter"),
                    $queryBuilder->expr()->eq('o.remote', ":remote$counter"),
                )
            );
                $queryBuilder
                    ->setParameter("name$counter", $criteria->getProfil())
                    ->setParameter("description$counter", $criteria->getProfil())
                    ->setParameter("assignment$counter", $criteria->getProfil())
                    ->setParameter("collaborator$counter", $criteria->getRemoteStatusLabel())
                    ->setParameter("minSalary$counter", $criteria->getSalary())
                    ->setParameter("maxSalary$counter", $criteria->getSalary())
                    ->setParameter("contractType$counter", $criteria->getContract())
                    ->setParameter("remote$counter", $criteria->getRemote());

            $counter++;
        }
        $queryBuilder->andWhere($orConditions);
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
