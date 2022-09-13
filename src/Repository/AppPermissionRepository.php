<?php

namespace App\Repository;

use App\Entity\Application;
use App\Entity\AppPermission;
use App\Entity\AppRole;
use App\Entity\AppUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppPermission>
 *
 * @method AppPermission|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppPermission|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppPermission[]    findAll()
 * @method AppPermission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppPermissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppPermission::class);
    }

    public function add(AppPermission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush)
        {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AppPermission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush)
        {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllWithNames()
    {
        return $this->createQueryBuilder('ap')
            ->select('ap.id', 'ap.user', 'ap.application', 'ap.role', 'ap.role', 'au.email', 'r.role as roleName', 'a.name as appName')
            ->innerJoin(
                Application::class,
                'a',
                Join::WITH,
                'a.id = ap.application')
            ->innerJoin(
                AppRole::class,
                'r',
                Join::WITH,
                'r.id = ap.role')
            ->innerJoin(
                AppUser::class,
                'au',
                Join::WITH,
                'au.id = ap.user')
            ->getQuery()
            ->getResult();
    }
}
