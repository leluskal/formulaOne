<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\TeamChief;

use App\Model\Repositories\ChiefRepository;
use App\Model\Repositories\TeamChiefRepository;
use App\Model\Repositories\TeamRepository;

class TeamChiefFormFactory
{
    private TeamRepository $teamRepository;

    private ChiefRepository $chiefRepository;

    private TeamChiefRepository $teamChiefRepository;

    public function __construct(
        TeamRepository $teamRepository,
        ChiefRepository $chiefRepository,
        TeamChiefRepository $teamChiefRepository
    )
    {
        $this->teamRepository = $teamRepository;
        $this->chiefRepository = $chiefRepository;
        $this->teamChiefRepository = $teamChiefRepository;
    }

    public function create(): TeamChiefForm
    {
        return new TeamChiefForm($this->teamRepository, $this->chiefRepository, $this->teamChiefRepository);
    }
}