<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\RaceResult\RaceResult;
use App\Model\Entities\TeamDriver\TeamDriver;
use Doctrine\ORM\Query\Expr\Join;

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

    public function getTotalResultsByYear(int $year): array
    {
        return $this->em->createQueryBuilder()
            ->select('d.firstname', 'd.lastname, SUM(ss.points) as totalPoints')
            ->from($this->entityName, 'e')
            ->leftJoin('e.driver', 'd')
            ->leftJoin('e.scoreSystem', 'ss')
            ->where('e.year = :year')
            ->setParameter('year', $year)
            ->groupBy('d.id')
            ->orderBy('totalPoints', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getTotalResultsByTeamIdAndYear(int $teamId, int $year): array
    {
        return $this->em->createQueryBuilder()
            ->select('t.name, t.name, SUM(ss.points) as totalPoints')
            ->from($this->entityName, 'e')
            ->join(TeamDriver::class, 'td', Join::WITH, 'td.driver = e.driver')
            ->leftJoin('e.scoreSystem', 'ss')
            ->leftJoin('td.team', 't')
            ->where('e.year = :year')
            ->setParameter('year', $year)
            ->groupBy('td.team')
//            ->orderBy('totalPoints', 'DESC')
            ->getQuery()
            ->getResult();
    }
}