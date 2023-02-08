<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\TeamDriver;

use App\Model\Repositories\DriverRepository;
use App\Model\Repositories\TeamDriverRepository;
use App\Model\Repositories\TeamRepository;

class TeamDriverFormFactory
{
    private TeamRepository $teamRepository;

    private DriverRepository $driverRepository;

    private TeamDriverRepository $teamDriverRepository;

    public function __construct(
        TeamRepository $teamRepository,
        DriverRepository $driverRepository,
        TeamDriverRepository $teamDriverRepository
    )
    {
        $this->teamRepository = $teamRepository;
        $this->driverRepository = $driverRepository;
        $this->teamDriverRepository = $teamDriverRepository;
    }

    public function create(): TeamDriverForm
    {
        return new TeamDriverForm($this->teamRepository, $this->driverRepository, $this->teamDriverRepository);
    }
}