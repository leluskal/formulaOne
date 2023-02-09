<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RaceResult;

use App\Model\Repositories\DriverRepository;
use App\Model\Repositories\RaceResultRepository;
use App\Model\Repositories\ScheduleRepository;
use App\Model\Repositories\ScoreSystemRepository;

class RaceResultFormFactory
{
    private ScheduleRepository $scheduleRepository;

    private DriverRepository $driverRepository;

    private ScoreSystemRepository $scoreSystemRepository;

    private RaceResultRepository $raceResultRepository;

    public function __construct(
        ScheduleRepository $scheduleRepository,
        DriverRepository $driverRepository,
        ScoreSystemRepository $scoreSystemRepository,
        RaceResultRepository $raceResultRepository
    )
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->driverRepository = $driverRepository;
        $this->scoreSystemRepository = $scoreSystemRepository;
        $this->raceResultRepository = $raceResultRepository;
    }

    public function create(): RaceResultForm
    {
        return new RaceResultForm(
            $this->scheduleRepository,
            $this->driverRepository,
            $this->scoreSystemRepository,
            $this->raceResultRepository
        );
    }
}