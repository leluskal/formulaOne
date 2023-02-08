<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\TeamChief\TeamChiefForm;
use App\AdminModule\Components\Forms\TeamChief\TeamChiefFormFactory;
use App\Model\Repositories\TeamChiefRepository;
use App\Presenters\BasePresenter;

class TeamChiefPresenter extends BasePresenter
{
    private TeamChiefRepository $teamChiefRepository;

    private TeamChiefFormFactory $teamChiefFormFactory;

    public function __construct(TeamChiefRepository $teamChiefRepository, TeamChiefFormFactory $teamChiefFormFactory)
    {
        $this->teamChiefRepository = $teamChiefRepository;
        $this->teamChiefFormFactory = $teamChiefFormFactory;
    }

    public function createComponentTeamChiefForm(): TeamChiefForm
    {
        $form = $this->teamChiefFormFactory->create();

        $form->onFinish[] = function (TeamChiefForm $teamChiefForm) {
            $this->redirect('TeamChief:default');
        };

        return $form;
    }

    public function renderDefault()
    {
        $this->template->teamChiefs = $this->teamChiefRepository->findAllByYear((int) $this->year);
        $this->template->year = $this->year;
    }

    public function renderEdit(int $id)
    {
        $teamChief = $this->teamChiefRepository->getById($id);
        $team = $teamChief->getTeam()->getId();
        $chief = $teamChief->getChief()->getId();

        $this['teamChiefForm']['form']['id']->setDefaultValue($teamChief->getId());
        $this['teamChiefForm']['form']['team_id']->setDefaultValue($team);
        $this['teamChiefForm']['form']['chief_id']->setDefaultValue($chief);
        $this['teamChiefForm']['form']['year']->setDefaultValue($teamChief->getYear());
    }

    public function renderCreate(int $year)
    {
        $this['teamChiefForm']['form']['year']->setDefaultValue($year);
    }

    public function handleDeleteTeamChief(int $id)
    {
        $teamChief = $this->teamChiefRepository->getById($id);

        $this->teamChiefRepository->delete($teamChief);
        $this->flashMessage('The record is deleted', 'info');
        $this->redirect('TeamChief:default');
    }

}