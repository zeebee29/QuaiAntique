<?php

namespace App\Repository;

use App\Entity\Reservation;
use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

/**
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function save(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Tableau de réservation
     *  - après la date passée en paramètre
     *  - regroupées par période date-midi ou date-soir
     *  - somme des convives sur cette période
     */
    public function findNotDispoAfter($date, $nbP): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "SELECT jour, plage, total "
            . "FROM ("
            . "SELECT DATE(resa.date_reservation) AS jour, SUM(resa.nb_convive) AS total, resa.midi_soir AS plage, resa.restaurant_id AS id "
            . "FROM reservation AS resa "
            . "WHERE resa.date_reservation > :jourJ "
            . "GROUP BY plage, jour "
            . ") AS temp "
            . "LEFT JOIN restaurant AS restau "
            . "ON restau.id = temp.id "
            . "WHERE total > restau.capacite - :nbP ";
        $params = ['nbP' => $nbP, 'jourJ' => $date->format('Y-m-d')];

        $result = $connection->executeQuery($sql, $params)->fetchAllAssociative();
        return $result;

        /*
        $subQuery = $this->createQueryBuilder('r_sub')
            ->select('r_sub.dateReservation, r_sub.midiSoir')
            ->join('r_sub.restaurant', 'restaurant_sub')
            ->groupBy('r_sub.dateReservation', 'r_sub.midiSoir')
            ->having('SUM(r_sub.nbConvive) >= restaurant_sub.capacite')
            ->getDQL();

        $query = $this->createQueryBuilder()
            ->select('r')
            ->from(Reservation::class, 'r')
            ->where($this->createQueryBuilder('r')->expr()->in('r.dateReservation', $subQuery))
            ->getQuery();

        $result = $query->getResult();
        return $result;
*/
        /*
            $requete->select('jour, plage, total')
            ->andWhere('r.dateReservation >= :jourJ')
            ->andWhere('totalConvive < :maxRestau')
            ->setParameter('jourJ', $date)
            ->setParameter('maxRestau', $capa)
            ->groupBy('r.midiSoir', 'jour')
            ->getQuery()
*//*
        return $this->createQueryBuilder('resa')
            ->select('DATE(resa.dateReservation) AS jour, UM(resa.nbConvive) AS total, resa.midiSoir, restaurant.capacite')
            ->andWhere('resa.dateReservation >= :jourJ')
            ->join('resa.restaurant', 'restaurant')
            ->groupBy('resa.midiSoir', 'resa.dateReservation')
            ->having('SUM(resa.nbConvive) > restaurant.capacite - :nbResa')
            ->orderBy('resa.dateReservation', 'ASC')
            ->setParameter('nbResa', $nbP)
            ->setParameter('jourJ', $date)
            ->getQuery()
            ->getResult();
    */
        /*
        $query = $this->getEntityManager()->createQuery("SELECT jour, plage "
            . "FROM ("
            . "SELECT DATE(resa.date_reservation) AS jour, SUM(resa.nb_convive) AS total, resa.midi_soir AS plage, resa.restaurant_id AS id "
            . "FROM reservation AS resa "
            . "GROUP BY plage, jour "
            . ") AS temp "
            . "LEFT JOIN restaurant AS restau "
            . "ON restau.id = temp.id "
            . "WHERE total >= restau.capacite ");
        return $query->getResult();
        */
        /*
        $query = $this->getEntityManager()->createQuery("SELECT jour, plage "
        . "FROM ("
        . "SELECT DATE(resa.date_reservation) AS jour, SUM(resa.nb_convive) AS total, resa.midi_soir AS plage, resa.restaurant_id AS id "
        . "FROM reservation AS resa "
        . "GROUP BY plage, jour "
        . ") AS temp "
        . "LEFT JOIN restaurant AS restau "
        . "ON restau.id = temp.id "
        . "WHERE total >= restau.capacite ");
        return $query->getResult();
*/
    }
    //    /**
    //     * @return Reservation[] Returns an array of Reservation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reservation
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
