<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Schedule;

use App\Model\Entities\Schedule\Schedule;
use App\Model\Repositories\ScheduleRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;
use DateTime;

class ScheduleForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private ScheduleRepository $scheduleRepository;

    public function __construct(ScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('date_from', 'Date From')
            ->setHtmlType('date')
            ->setRequired('The date is required');

        $form->addText('date_to', 'Date To')
            ->setHtmlType('date')
            ->setRequired('The date is required');

        $form->addText('name', 'Grand Prix')
             ->setRequired('The name is required');

        $form->addHidden('year');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->id === '') {
            $schedule = new Schedule(
                DateTime::createFromFormat('Y-m-d', $values->date_from),
                DateTime::createFromFormat('Y-m-d', $values->date_to),
                $values->name,
                (int) $values->year
            );

            $this->scheduleRepository->save($schedule);
            $this->getPresenter()->flashMessage('The new schedule record is saved', 'success');
        }

        if ($values->id !== '') {
            $schedule = $this->scheduleRepository->getById((int) $values->id);

            $schedule->setDateFrom(DateTime::createFromFormat('Y-m-d', $values->date_from));
            $schedule->setDateTo(DateTime::createFromFormat('Y-m-d', $values->date_to));
            $schedule->setName($values->name);
            $schedule->setYear((int) $values->year);

            $this->scheduleRepository->save($schedule);
            $this->getPresenter()->flashMessage('The schedule record is updated', 'info');
        }

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/scheduleForm.latte');
        $template->render();
    }
}