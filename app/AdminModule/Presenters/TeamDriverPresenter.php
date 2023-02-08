<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\TeamDriver\TeamDriverForm;
use App\AdminModule\Components\Forms\TeamDriver\TeamDriverFormFactory;
use App\Model\Repositories\TeamDriverRepository;
use App\Presenters\BasePresenter;

class TeamDriverPresenter extends BasePresenter
{
    private TeamDriverRepository $teamDriverRepository;

    private TeamDriverFormFactory $teamDriverFormFactory;

    public function __construct(TeamDriverRepository $teamDriverRepository, TeamDriverFormFactory $teamDriverFormFactory)
    {
        $this->teamDriverRepository = $teamDriverRepository;
        $this->teamDriverFormFactory = $teamDriverFormFactory;
    }

    public function createComponentTeamDriverForm(): TeamDriverForm
    {
        $form = $this->teamDriverFormFactory->create();

        $form->onFinish[] = function (TeamDriverForm $teamDriverForm) {
            $this->redirect('TeamDriver:default');
        };

        return $form;
    }

    public function renderDefault()
    {
        $this->template->teamDrivers = $this->teamDriverRepository->findAllByYear((int) $this->year);
        $this->template->year = $this->year;
    }

    public function renderEdit(int $id)
    {
        $teamDriver = $this->teamDriverRepository->getById($id);
        $team = $teamDriver->getTeam()->getId();
        $driver = $teamDriver->getDriver()->getId();

        $this['teamDriverForm']['form']['id']->setDefaultValue($teamDriver->getId());
        $this['teamDriverForm']['form']['team_id']->setDefaultValue($team);
        $this['teamDriverForm']['form']['driver_id']->setDefaultValue($driver);
        $this['teamDriverForm']['form']['year']->setDefaultValue($teamDriver->getYear());
    }

    public function renderCreate(int $year)
    {
        $this['teamDriverForm']['form']['year']->setDefaultValue($year);
    }

    public function handleDeleteTeamDriver(int $id)
    {
        $teamDriver = $this->teamDriverRepository->getById($id);

        $this->teamDriverRepository->delete($teamDriver);
        $this->flashMessage('The record is deleted', 'info');
        $this->redirect('TeamDriver:default');
    }


}