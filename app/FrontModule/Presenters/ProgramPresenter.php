<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model\Repositories\ScheduleDetailRepository;
use App\Model\Repositories\ScheduleRepository;
use App\Presenters\BasePresenter;

class ProgramPresenter extends BasePresenter
{
    private ScheduleRepository $scheduleRepository;

    private ScheduleDetailRepository $scheduleDetailRepository;

    public function __construct(ScheduleRepository $scheduleRepository, ScheduleDetailRepository $scheduleDetailRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->scheduleDetailRepository = $scheduleDetailRepository;
    }

    public function renderDefault()
    {
        $this->template->schedules  = $this->scheduleRepository->findAllByYear((int) $this->year);


        $this->template->year = $this->year;
    }


}