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

        $sql = "SELECT jour, plage "
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
    }

    public function testDispoAfter($jourJ, $nbP, $dateReservation, $plage): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = 'SELECT jour, plage
            FROM (
            SELECT DATE(resa.date_reservation) AS jour, SUM(resa.nb_convive) AS total, resa.midi_soir AS plage, resa.restaurant_id AS id
            FROM reservation AS resa
            WHERE resa.date_reservation > :jourJ
            AND DATE(resa.date_reservation) = DATE(:dateR)
            AND resa.midi_soir = :plage
            GROUP BY plage, jour
            ) AS temp
            LEFT JOIN restaurant AS restau
            ON restau.id = temp.id
            WHERE total > restau.capacite - :nbP';
        
        $params = [
            'nbP' => $nbP,
            'jourJ' => $jourJ->format('Y-m-d'),
            'dateR' => $dateReservation,
            'plage' => $plage,
        ];

        $result = $connection->executeQuery($sql, $params)->fetchAllAssociative();
        return $result;
    }


    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findByUserField($user): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = 'SELECT date_reservation, nb_convive, status, email, tel_reserv
            FROM reservation AS r
            WHERE r.user_id = :user
            ORDER BY date_reservation DESC'
            ;
        $params = [
            'user' => $user->getId(),
        ];

        $result = $connection->executeQuery($sql, $params)->fetchAllAssociative();
        return $result;
    }
}
