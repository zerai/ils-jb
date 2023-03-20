<?php declare(strict_types=1);

namespace JobPosting\Adapter\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use JobPosting\Application\Model\JobPost\JobPost;

/**
 * @extends ServiceEntityRepository<JobPost>
 *
 * @method JobPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobPost[]    findAll()
 * @method JobPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class MySqlJobPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobPost::class);
    }

    public function add(JobPost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JobPost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
