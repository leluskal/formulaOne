<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\ScoreSystem;

use App\Model\Entities\ScoreSystem\ScoreSystem;
use App\Model\Repositories\ScoreSystemRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class ScoreSystemForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private ScoreSystemRepository $scoreSystemRepository;

    public function __construct(ScoreSystemRepository $scoreSystemRepository)
    {
        $this->scoreSystemRepository = $scoreSystemRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addInteger('position', 'Position')
             ->setRequired('The position is required');

        $form->addInteger('points', 'Points')
             ->setRequired('The points are required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->id === '') {
            $scoreSystem = new ScoreSystem(
                $values->position,
                $values->points
            );

            $this->scoreSystemRepository->save($scoreSystem);
            $this->getPresenter()->flashMessage('The new record is saved', 'success');
        }

        if ($values->id !== '') {
            $scoreSystem = $this->scoreSystemRepository->getById((int) $values->id);

            $scoreSystem->setPosition($values->position);
            $scoreSystem->setPoints($values->points);

            $this->scoreSystemRepository->save($scoreSystem);
            $this->getPresenter()->flashMessage('The record is updated', 'info');
        }

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/scoreSystemForm.latte');
        $template->render();
    }
}