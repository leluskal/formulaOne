<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\TeamDriver\TeamDriver;

/**
 * @method TeamDriver|null getById(int $id)
 * @method TeamDriver save(TeamDriver $entity)
 */
class TeamDriverRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return TeamDriver::class;
    }

    /**
     * @param int $year
     * @return TeamDriver[]
     */
    public function findAllByYear(int $year): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->where('e.year = :year')
            ->setParameter('year', $year)
            ->getQuery()
            ->getResult();
    }
}