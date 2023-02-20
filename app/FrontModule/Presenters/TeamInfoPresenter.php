<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model\Repositories\TeamChiefRepository;
use App\Model\Repositories\TeamDriverRepository;
use App\Model\Repositories\TeamRepository;
use App\Presenters\BasePresenter;

class TeamInfoPresenter extends BasePresenter
{
    private TeamDriverRepository $teamDriverRepository;

    private TeamChiefRepository $teamChiefRepository;

    private TeamRepository $teamRepository;

    public function __construct(
        TeamDriverRepository $teamDriverRepository,
        TeamChiefRepository $teamChiefRepository,
        TeamRepository $teamRepository
    )
    {
        $this->teamDriverRepository = $teamDriverRepository;
        $this->teamChiefRepository = $teamChiefRepository;
        $this->teamRepository = $teamRepository;
    }

    public function renderDefault(int $teamId = null)
    {
        $this->template->teams = $this->teamRepository->findAll();
        $this->template->teamId = $teamId;

        if ($teamId !== null) {
            $this->template->teamName = $this->teamRepository->getById($teamId);
            $this->template->teamDrivers = $this->teamDriverRepository->findAllByTeamIdAndYear($teamId, (int) $this->year);
            $this->template->teamChiefs = $this->teamChiefRepository->findAllByTeamIdAndYear($teamId, (int) $this->year);
        }

        $this->template->year = $this->year;
    }
}