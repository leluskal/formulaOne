<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\Driver\Driver;

/**
 * @method Driver|null getById(int $id)
 * @method Driver save(Driver $entity)
 */
class DriverRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return Driver::class;
    }

    /**
     * @return Driver[]
     */
    public function findAll(): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->orderBy('e.firstname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllForSelectBox(): array
    {
        $drivers = $this->findAll();

        $returnArray = [];

        foreach ($drivers as $driver) {
            $returnArray[$driver->getId()] = $driver->getFirstname() . '  ' . $driver->getLastname();
        }

        return $returnArray;
    }
}