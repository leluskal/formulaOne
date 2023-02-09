<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\Schedule\Schedule;

/**
 * @method Schedule|null getById(int $id)
 * @method Schedule save(Schedule $entity)
 */
class ScheduleRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return Schedule::class;
    }

    /**
     * @return Schedule[]
     */
    public function findAll(): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $year
     * @return Schedule[]
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

    public function findAllForSelectBox(): array
    {
        $schedules = $this->findAll();

        $returnArray = [];

        foreach ($schedules as $schedule) {
            $dateFrom = $schedule->getDateFrom()->format('d.m.Y');
            $dateTo = $schedule->getDateTo()->format('d.m.Y');
            $returnArray[$schedule->getId()] = $dateFrom . ' - ' . $dateTo . '  ' . $schedule->getName();
        }

        return $returnArray;
    }


}