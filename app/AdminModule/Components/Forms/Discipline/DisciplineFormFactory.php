<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Discipline;

use App\Model\Repositories\DisciplineRepository;

class DisciplineFormFactory
{
    private DisciplineRepository $disciplineRepository;

    public function __construct(DisciplineRepository $disciplineRepository)
    {
        $this->disciplineRepository = $disciplineRepository;
    }

    public function create(): DisciplineForm
    {
        return new DisciplineForm($this->disciplineRepository);
    }
}