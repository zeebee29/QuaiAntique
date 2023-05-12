<?php

namespace App\Repository;

use App\Entity\OuvertureHebdo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OuvertureHebdo>
 *
 * @method OuvertureHebdo|null find($id, $lockMode = null, $lockVersion = null)
 * @method OuvertureHebdo|null findOneBy(array $criteria, array $orderBy = null)
 * @method OuvertureHebdo[]    findAll()
 * @method OuvertureHebdo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OuvertureHebdoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OuvertureHebdo::class);
    }

    public function save(OuvertureHebdo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OuvertureHebdo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return OuvertureHebdo[] Returns an array of OuvertureHebdo objects
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

//    public function findOneBySomeField($value): ?OuvertureHebdo
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
