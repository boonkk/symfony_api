<?php

namespace App\Repository;

use App\Entity\Application;
use App\Entity\AppPermission;
use App\Entity\AppRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Application>
 *
 * @method Application|null find($id, $lockMode = null, $lockVersion = null)
 * @method Application|null findOneBy(array $criteria, array $orderBy = null)
 * @method Application[]    findAll()
 * @method Application[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Application::class);
    }

    public function add(Application $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush)
        {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Application $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush)
        {
            $this->getEntityManager()->flush();
        }
    }

    public function findByAppUser(int $appUserId)
    {
        return $this->createQueryBuilder('a')
            ->select('a.id', 'a.name', 'a.description', 'ap.role', 'r.role as roleName')
            ->innerJoin(
                AppPermission::class,
                'ap',
                Join::WITH,
                'a.id = ap.application')
            ->innerJoin(
                AppRole::class,
                'r',
                Join::WITH,
                'r.id = ap.role')
            ->where('ap.user = :userId')
            ->setParameter('userId', $appUserId)
            ->getQuery()
            ->getResult();
    }

    public function findAllArray(): array
    {
        return $this->createQueryBuilder('a')
            ->select('a.id', 'a.name', 'a.description')
            ->getQuery()
            ->getResult();

    }
}
