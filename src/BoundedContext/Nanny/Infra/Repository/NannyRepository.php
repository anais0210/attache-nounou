<?php

namespace App\BoundedContext\Nanny\Infra\Repository;

use App\BoundedContext\Nanny\Domain\Model\Nanny;
use App\BoundedContext\Nanny\Domain\RepositoryInterface\NannyRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class NannyRepository
 *
 * @author Sparesotto Anaïs <a.sparesotto@icloud.com>
 */
class NannyRepository extends ServiceEntityRepository implements NannyRepositoryInterface
{
    /**
     * NannyRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nanny::class);
    }

    /**
     * @param  Nanny $nanny
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Nanny $nanny): void
    {
        $this->getEntityManager()->persist($nanny);
        $this->getEntityManager()->flush();
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT n
            FROM App\BoundedContext\Nanny\Domain\Model\Nanny n '
        );
        return $query->getResult();
    }
}

