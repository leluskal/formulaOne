<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Team;

use App\Model\Repositories\TeamRepository;

class TeamFormFactory
{
    private TeamRepository $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function create(): TeamForm
    {
        return new TeamForm($this->teamRepository);
    }

}