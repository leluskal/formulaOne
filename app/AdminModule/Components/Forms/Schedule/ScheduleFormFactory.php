<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Schedule;

use App\Model\Repositories\ScheduleRepository;

class ScheduleFormFactory
{
    private ScheduleRepository $scheduleRepository;

    public function __construct(ScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function create(): ScheduleForm
    {
        return new ScheduleForm($this->scheduleRepository);
    }
}