<?php

namespace App\Repository;

use App\Entity\Criteria;
use App\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function findMatchingCriteria(Offer $offer): array
    {
        $qb = $this->createQueryBuilder('c');
        /*$qb->where(
            $qb->expr()->gte(
                $qb->expr()->sum(
                    $qb->expr()->sum('c.salary >= :minSalary', 'c.salary <= :maxSalary'),
                    $qb->expr()->sum(
                        'c.contractType = :contractType',
                        $qb->expr()->sum(
                            'c.remote = :remote',
                            $qb->expr()->sum(
                                'c.profil LIKE :jobTitle',
                                'c.location LIKE :location'
                            )
                        )
                    )
                ),
                2
            )
        )*/
        $qb->where('c.salary >= :minSalary')
            ->setParameter('minSalary', $offer->getMinSalary())
        ->orWhere('c.contract = :contractType')
            ->setParameter('contractType', $offer->getContractType())
        ->orWhere('c.remote = :remote')
            ->setParameter('remote', $offer->getRemote())
        ->orWhere('c.profil LIKE :jobTitle')
            ->setParameter('jobTitle', "%" . $offer->getName() . "%")
        ->orWhere('c.location LIKE :location')
            ->setParameter('location', "%" . $offer->getAssignment() . "%");

        $query = $qb->getQuery();

        return $query->getResult();
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
