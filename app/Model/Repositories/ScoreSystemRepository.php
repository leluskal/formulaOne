<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\ScoreSystem\ScoreSystem;

/**
 * @method ScoreSystem|null getById(int $id)
 * @method ScoreSystem save(ScoreSystem $entity)
 */
class ScoreSystemRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return ScoreSystem::class;
    }

    /**
     * @return ScoreSystem[]
     */
    public function findAll(): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->getQuery()
            ->getResult();
    }

    public function findAllForSelectBox(): array
    {
        $scoreSystems = $this->findAll();

        $returnArray = [];

        foreach ($scoreSystems as $scoreSystem) {
            $returnArray[$scoreSystem->getId()] = $scoreSystem->getPoints() . '. (' . $scoreSystem->getPoints() . ' pts)';
        }

        return $returnArray;
    }
}