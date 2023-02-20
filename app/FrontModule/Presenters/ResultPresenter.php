<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model\Repositories\RaceResultRepository;
use App\Model\Repositories\ScheduleRepository;
use App\Presenters\BasePresenter;

class ResultPresenter extends BasePresenter
{
    private RaceResultRepository $raceResultRepository;

    private ScheduleRepository $scheduleRepository;

    public function __construct(RaceResultRepository $raceResultRepository, ScheduleRepository $scheduleRepository)
    {
        $this->raceResultRepository = $raceResultRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    public function renderDefault(string $type = null, $teamId = null)
    {
        if ($type === 'races') {
            $this->template->schedules = $this->scheduleRepository->findAllByYear((int) $this->year);
        }

        if ($type === 'drivers') {
            $this->template->driverResults = $this->raceResultRepository->getTotalResultsByYear((int) $this->year);
        }

        if ($type === 'teams') {
            $this->template->teamResults = $this->raceResultRepository->getTotalResultsByTeamIdAndYear((int) $teamId, (int) $this->year);
        }

        $this->template->type = $type;
        $this->template->year = $this->year;
    }

    public function renderRaceResult(int $scheduleId)
    {
        $this->template->schedule = $this->scheduleRepository->getById($scheduleId);
        $this->template->raceResults = $this->raceResultRepository->findAllByScheduleId($scheduleId);
    }
}