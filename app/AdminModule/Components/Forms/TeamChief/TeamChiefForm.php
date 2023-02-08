<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\TeamChief;

use App\Model\Entities\TeamChief\TeamChief;
use App\Model\Repositories\ChiefRepository;
use App\Model\Repositories\TeamChiefRepository;
use App\Model\Repositories\TeamRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class TeamChiefForm extends Control
{
    use SmartObject;

    public array $onFinish;

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

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('team_id', 'Team', $this->teamRepository->findAllForSelectBox())
            ->setPrompt('--Choose team--')
             ->setRequired('The team is required');

        $form->addSelect('chief_id', 'Chief', $this->chiefRepository->findAllForSelectBox())
             ->setPrompt('--Choose chief--')
             ->setRequired('The chief is required');

        $form->addHidden('year');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        $team = $this->teamRepository->getById((int) $values->team_id);
        $chief = $this->chiefRepository->getById((int) $values->chief_id);

        if ($values->id === '') {
            $teamChief = new TeamChief(
                $team,
                $chief,
                (int) $values->year
            );

            $this->teamChiefRepository->save($teamChief);
            $this->getPresenter()->flashMessage('The new record is saved', 'success');
        }

        if ($values->id !== '') {
            $teamChief = $this->teamChiefRepository->getById((int) $values->id);

            $teamChief->setTeam($team);
            $teamChief->setChief($chief);
            $teamChief->setYear((int) $values->year);

            $this->teamChiefRepository->save($teamChief);
            $this->getPresenter()->flashMessage('The record is updated', 'info');
        }

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/teamChiefForm.latte');
        $template->render();
    }




}