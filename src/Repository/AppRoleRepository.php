<?php

namespace App\Repository;

use App\Entity\AppRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppRole>
 *
 * @method AppRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppRole[]    findAll()
 * @method AppRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppRole::class);
    }

    public function add(AppRole $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush)
        {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AppRole $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush)
        {
            $this->getEntityManager()->flush();
        }
    }
}
