<?php

namespace App\Repository;

use App\Entity\ToPlay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ToPlay>
 *
 * @method ToPlay|null find($id, $lockMode = null, $lockVersion = null)
 * @method ToPlay|null findOneBy(array $criteria, array $orderBy = null)
 * @method ToPlay[]    findAll()
 * @method ToPlay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ToPlayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ToPlay::class);
    }

    public function add(ToPlay $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ToPlay $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ToPlay[] Returns an array of ToPlay objects
//     */
    public function findAllEloByUser($id, $idGame): array
    {
        return $this->createQueryBuilder('t')
            ->select('t.elo, t.pseudonyme, g.name, t.dateRegisterElo' )
            ->innerJoin('t.game', 'g')
            ->innerJoin('t.user', 'u')
            ->where('u.id = ' . $id)
            ->andWhere('g.id = ' . $idGame)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?ToPlay
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
