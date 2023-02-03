<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\Team\Team;

/**
 * @method Team|null getById(int $id)
 * @method Team save(Team $entity)
 */
class TeamRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return Team::class;
    }

    /**
     * @return Team[]
     */
    public function findAll(): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->getQuery()
            ->getResult();
    }
}