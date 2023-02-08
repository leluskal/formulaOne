<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\TeamDriver;

use App\Model\Entities\TeamDriver\TeamDriver;
use App\Model\Repositories\DriverRepository;
use App\Model\Repositories\TeamDriverRepository;
use App\Model\Repositories\TeamRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class TeamDriverForm extends Control
{
    use SmartObject;

    public array $onFinish;

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

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('team_id', 'Team', $this->teamRepository->findAllForSelectBox())
            ->setPrompt('--Choose team--')
            ->setRequired('The team is required');

        $form->addSelect('driver_id', 'Driver', $this->driverRepository->findAllForSelectBox())
            ->setPrompt('--Choose driver--')
            ->setRequired('The driver is required');

        $form->addHidden('year');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }


    public function formSuccess(Form $form, ArrayHash $values)
    {
        $team = $this->teamRepository->getById((int) $values->team_id);
        $driver = $this->driverRepository->getById((int) $values->driver_id);

        if ($values->id === '') {
            $teamDriver = new TeamDriver(
                $team,
                $driver,
                (int) $values->year
            );

            $this->teamDriverRepository->save($teamDriver);
            $this->getPresenter()->flashMessage('The new record is saved', 'success');
        }

        if ($values->id !== '') {
            $teamDriver = $this->teamDriverRepository->getById((int) $values->id);

            $teamDriver->setTeam($team);
            $teamDriver->setDriver($driver);
            $teamDriver->setYear((int) $values->year);

            $this->teamDriverRepository->save($teamDriver);
            $this->getPresenter()->flashMessage('The record is updated', 'info');

            bdump($teamDriver);
        }

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/teamDriverForm.latte');
        $template->render();
    }
}