<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Discipline;

use App\Model\Entities\Discipline\Discipline;
use App\Model\Repositories\DisciplineRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class DisciplineForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private DisciplineRepository $disciplineRepository;

    public function __construct(DisciplineRepository $disciplineRepository)
    {
        $this->disciplineRepository = $disciplineRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Discipline')
             ->setRequired('The name is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->id === '') {
            $discipline = new Discipline(
                $values->name,
            );

            $this->disciplineRepository->save($discipline);
            $this->getPresenter()->flashMessage('The new discipline is saved', 'success');
        }

        if ($values->id !== '') {
            $discipline = $this->disciplineRepository->getById((int)$values->id);

            $discipline->setName($values->name);

            $this->disciplineRepository->save($discipline);
            $this->getPresenter()->flashMessage('The discipline record is updated', 'info');
        }

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/disciplineForm.latte');
        $template->render();
    }
}