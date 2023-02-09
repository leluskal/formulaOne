<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\ScheduleDetail\ScheduleDetail;

/**
 * @method ScheduleDetail|null getById(int $id)
 * @method ScheduleDetail save(ScheduleDetail $entity)
 */
class ScheduleDetailRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return ScheduleDetail::class;
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