<?php

namespace App\Repository;

use App\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
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
    //private $registry;
    public function __construct(ManagerRegistry $registry)
    {
        //$this->registry = $registry;
        parent::__construct($registry, Offer::class);
    }

    public function findMatchingCriteria(Collection $offerCollection): array
    {
        $manager = $this->getEntityManager();
        $queryBuilder = $manager->createQueryBuilder();
        $expr = $queryBuilder->expr();

        $mainQuery = $queryBuilder->select('o')
            ->from('App\Entity\Offer', 'o');

        $counter = 0;
        $orConditions = [];

        foreach ($offerCollection as $criteria) {
            $orConditions[] = $queryBuilder->expr()->gte(
                '(' .
                "CASE WHEN o.name LIKE :name$counter THEN 1 ELSE 0 END + " .
                "CASE WHEN o.assignment LIKE :assignment$counter THEN 1 ELSE 0 END + " .
                "CASE WHEN (o.minSalary >= :salary$counter OR o.maxSalary <= :salary$counter) THEN 1 ELSE 0 END + " .
                "CASE WHEN o.contractType = :contract$counter THEN 1 ELSE 0 END + " .
                "CASE WHEN o.remote = :remote$counter THEN 1 ELSE 0 END)",
                '2'
            );

            $queryBuilder->setParameter("name$counter", '%' . $criteria->getProfil() . '%');
            $queryBuilder->setParameter("assignment$counter", '%' . $criteria->getLocation() . '%');
            $queryBuilder->setParameter("salary$counter", $criteria->getSalary());
            $queryBuilder->setParameter("contract$counter", $criteria->getContract());
            $queryBuilder->setParameter("remote$counter", $criteria->getRemote());

            $counter++;
        }

        $mainQuery->where(
            $expr->orX(...$orConditions)
        );

        return $mainQuery->getQuery()->getResult();
    }

    public function queryfindAll()
    {
        return $this->createQueryBuilder('o')->getQuery();
    }

    public function findLikeName(string $search, ?Offer $offer): Query
    {
        $query = $this->createQueryBuilder('o')
            ->andWhere('o.name LIKE :search')
            ->setParameter('search', '%' . $search . '%');

           return $query->getQuery()->getResult();
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
