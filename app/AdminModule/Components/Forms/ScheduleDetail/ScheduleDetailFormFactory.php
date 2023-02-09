<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\ScheduleDetail;

use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\ScheduleDetailRepository;
use App\Model\Repositories\ScheduleRepository;

class ScheduleDetailFormFactory
{
    private ScheduleRepository $scheduleRepository;

    private DisciplineRepository $disciplineRepository;

    private ScheduleDetailRepository $scheduleDetailRepository;

    public function __construct(
        ScheduleRepository $scheduleRepository,
        DisciplineRepository $disciplineRepository,
        ScheduleDetailRepository $scheduleDetailRepository
    )
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->disciplineRepository = $disciplineRepository;
        $this->scheduleDetailRepository = $scheduleDetailRepository;
    }

    public function create(): ScheduleDetailForm
    {
        return new ScheduleDetailForm($this->scheduleRepository, $this->disciplineRepository, $this->scheduleDetailRepository);
    }
}