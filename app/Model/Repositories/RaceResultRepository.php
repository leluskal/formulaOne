<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\RaceResult\RaceResult;

/**
 * @method RaceResult|null getById(int $id)
 * @method RaceResult save(RaceResult $entity)
 */
class RaceResultRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return RaceResult::class;
    }

    public function findAllByScheduleId(int $scheduleId): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->where('e.schedule = :schedule_id')
            ->setParameter('schedule_id', $scheduleId)
            ->getQuery()
            ->getResult();
    }
}