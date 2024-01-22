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
        $manager = $this->getEntityManager();
        $queryBuilder = $manager->createQueryBuilder();

        $mainQuery = $queryBuilder->select('c')
            ->from('App\Entity\Criteria', 'c');

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

        /*$qb->where('c.salary >= :minSalary')
            ->setParameter('minSalary', $offer->getMinSalary())
        ->orWhere('c.contract = :contractType')
            ->setParameter('contractType', $offer->getContractType())
        ->orWhere('c.remote = :remote')
            ->setParameter('remote', $offer->getRemote())
        ->orWhere('c.profil LIKE :jobTitle')
            ->setParameter('jobTitle', "%" . $offer->getName() . "%")
        ->orWhere('c.location LIKE :location')
            ->setParameter('location', "%" . $offer->getAssignment() . "%");*/

        $condition = $queryBuilder->expr()->gte(
            '(' .
            "CASE WHEN c.profil LIKE :profil THEN 1 ELSE 0 END + " .
            "CASE WHEN c.location LIKE :location THEN 1 ELSE 0 END + " .
            "CASE WHEN (c.salary >= :minSalary AND c.salary <= :maxSalary) THEN 1 ELSE 0 END + " .
            "CASE WHEN c.contract = :contract THEN 1 ELSE 0 END + " .
            "CASE WHEN c.remote = :remote THEN 1 ELSE 0 END)",
            '2'
        );

        $queryBuilder->setParameter("profil", '%' . $offer->getName() . '%');
        $queryBuilder->setParameter("location", '%' . $offer->getAssignment() . '%');
        $queryBuilder->setParameter("minSalary", $offer->getMinSalary());
        $queryBuilder->setParameter("maxSalary", $offer->getMaxSalary());
        $queryBuilder->setParameter("contract", $offer->getContractType());
        $queryBuilder->setParameter("remote", $offer->getRemote());

        $mainQuery->where($condition);

        //$query = $qb->getQuery();

        //return $query->getResult();
        return $mainQuery->getQuery()->getResult();
    }
}
