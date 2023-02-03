<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\Chief\Chief;

/**
 * @method Chief|null getById(int $id)
 * @method Chief save(Chief $entity)
 */
class ChiefRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return Chief::class;
    }

    /**
     * @return Chief[]
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