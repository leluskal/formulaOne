<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Team;

use App\Model\Entities\Team\Team;
use App\Model\Repositories\TeamRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class TeamForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private TeamRepository $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Team');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->id === '') {
            $team = new Team(
                $values->name
            );

            $this->teamRepository->save($team);
            $this->getPresenter()->flashMessage('The new team is saved', 'success');
        }

        if ($values->id !== '') {
            $team = $this->teamRepository->getById((int) $values->id);

            $team->setName($values->name);

            $this->teamRepository->save($team);
            $this->getPresenter()->flashMessage('The team record is updated', 'info');
        }

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/teamForm.latte');
        $template->render();
    }
}