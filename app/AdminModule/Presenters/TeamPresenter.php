<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Team\TeamForm;
use App\AdminModule\Components\Forms\Team\TeamFormFactory;
use App\Model\Repositories\TeamRepository;
use App\Presenters\BasePresenter;

class TeamPresenter extends BasePresenter
{
    private TeamRepository $teamRepository;

    private TeamFormFactory $teamFormFactory;

    public function __construct(TeamRepository $teamRepository, TeamFormFactory $teamFormFactory)
    {
        $this->teamRepository = $teamRepository;
        $this->teamFormFactory = $teamFormFactory;
    }

    public function createComponentTeamForm(): TeamForm
    {
        $form = $this->teamFormFactory->create();

        $form->onFinish[] = function (TeamForm $teamForm) {
            $this->redirect('Team:default');
        };

        return $form;
    }

    public function renderDefault()
    {
        $this->template->teams = $this->teamRepository->findAll();
    }

    public function renderEdit(int $id)
    {
        $team = $this->teamRepository->getById($id);

        $this['teamForm']['form']['id']->setDefaultValue($team->getId());
        $this['teamForm']['form']['name']->setDefaultValue($team->getName());
        $this['teamForm']['form']['image']->setDefaultValue($team->getImagePath());

    }

    public function renderCreate()
    {

    }

    public function handleDeleteTeam(int $id)
    {
        $team = $this->teamRepository->getById($id);

        $this->teamRepository->delete($team);
        $this->flashMessage('The team record is deleted', 'info');
        $this->redirect('Team:default');
    }


}