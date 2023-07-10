<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Restaurant>
 *
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    public function save(Restaurant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Restaurant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Restaurant[] Returns an array of Restaurant objects
     */
    public function findCoordonnees(): array
    {
        return $this->createQueryBuilder('r')
            ->select('r.adresse', 'r.tel')
            ->getQuery()
            ->getResult();
    }
    
    public function getId(): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "SELECT id FROM `restaurant` WHERE id IS NOT NULL";

        $result = $connection->executeQuery($sql)->fetchAllAssociative();
        return $result;
    }

}
