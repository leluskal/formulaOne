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

    /**
     * @param int $year
     * @return TeamChief[]
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

    /**
     * @param int $teamId
     * @param int $year
     * @return TeamChief[]
     */
    public function findAllByTeamIdAndYear(int $teamId, int $year): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->where('e.team = :teamId')
            ->setParameter('teamId', $teamId)
            ->andWhere('e.year = :year')
            ->setParameter('year', $year)
            ->getQuery()
            ->getResult();
    }
}