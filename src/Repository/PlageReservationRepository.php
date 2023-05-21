<?php

namespace App\Repository;

use App\Entity\PlageReservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlageReservation>
 *
 * @method PlageReservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlageReservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlageReservation[]    findAll()
 * @method PlageReservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlageReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlageReservation::class);
    }

    public function save(PlageReservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PlageReservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findAllPlages(): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "SELECT midi_soir AS plage, SUBSTRING(heure_plage FROM 1 FOR 5) AS heure"
            . " FROM plage_reservation";

        $result = $connection->executeQuery($sql)->fetchAllAssociative();
        return $result;
    }
    //    /**
    //     * @return PlageReservation[] Returns an array of PlageReservation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PlageReservation
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
