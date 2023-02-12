<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

//requete sous format sql
//SELECT  u.name , firstname, pseudonyme, MAX(elo), MIN(elo), g.name from to_play
//INNER join user AS u on u.id = to_play.user_id
//INNER join game as g on g.id = to_play.game_id
//GROUP BY pseudonyme, g.name ORDER BY u.name;


//    /**
//     * @return User[] Returns an array of User objects
//     */
    public function findUserLight(): array
    {
        return $this->createQueryBuilder('u')
            ->select('u.name, u.firstname, u.id')
            ->orderBy('u.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
//SELECT  u.id , g.name from to_play
//INNER join user AS u on u.id = to_play.user_id
//INNER join game as g on g.id = to_play.game_id
//WHERE u.id = 1
//GROUP BY g.name
    public function findGamesByUser($id):array
    {
        return $this->createQueryBuilder('u')
            ->select('u.id', 'g.name as nameGame', 'g.id as idGame', 't.pseudonyme as pseudo', 'MAX(t.elo) as maxElo', 'MIN(t.elo) as minElo')
            ->innerJoin('u.toPlays', 't')
            ->innerJoin('t.game', 'g')
            ->where('u.id = ' . $id)
            ->groupBy( 'g.name')
            ->getQuery()
            ->getResult()
            ;
    }

    public function searchBarre($search):array
    {
        return $this->createQueryBuilder('u')
            ->select('u.name', 'u.firstname', 'u.id')
//            ->innerJoin('u.toPlays', 't')
            ->where('u.name LIKE :search')
            ->orWhere('u.firstname LIKE :search')
//            ->orWhere('t.pseudonyme LIKE :search')
//            ->groupBy('t.pseudonyme')
            ->setParameter('search', '%'.$search.'%')
            ->getQuery()
            ->getResult()
            ;
    }

//

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
