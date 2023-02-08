<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\TeamChief\TeamChief;

/**
 * @method TeamChief|null getById(int $id)
 * @method TeamChief save(TeamChief $entity)
 */
class TeamChiefRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return TeamChief::class;
    }

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