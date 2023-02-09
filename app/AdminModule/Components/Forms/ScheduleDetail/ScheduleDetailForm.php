<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\ScheduleDetail;

use App\Model\Entities\ScheduleDetail\ScheduleDetail;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\ScheduleDetailRepository;
use App\Model\Repositories\ScheduleRepository;
use DateTime;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class ScheduleDetailForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private int $scheduleId;

    private ScheduleRepository $scheduleRepository;

    private DisciplineRepository $disciplineRepository;

    private ScheduleDetailRepository $scheduleDetailRepository;

    public function __construct(
        ScheduleRepository $scheduleRepository,
        DisciplineRepository $disciplineRepository,
        ScheduleDetailRepository $scheduleDetailRepository
    )
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->disciplineRepository = $disciplineRepository;
        $this->scheduleDetailRepository = $scheduleDetailRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('schedule_id', 'Schedule', $this->scheduleRepository->findAllForSelectBox())
             ->setPrompt('--Choose schedule--')
             ->setRequired('The schedule is required');

        $form->addText('event_date', 'Event Date')
             ->setHtmlType('datetime-local')
             ->setRequired('The event date is required');

        $form->addSelect('discipline_id', 'Discipline', $this->disciplineRepository->findAllForSelectBox())
             ->setPrompt('--Choose discipline--')
             ->setRequired('The discipline is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        $schedule = $this->scheduleRepository->getById((int) $values->schedule_id);
        $discipline = $this->disciplineRepository->getById((int) $values->discipline_id);

        if ($values->id === '') {
            $scheduleDetail = new ScheduleDetail(
                $schedule,
                DateTime::createFromFormat('Y-m-d\TH:i', $values->event_date),
                $discipline
            );

            $this->scheduleDetailRepository->save($scheduleDetail);
            $this->getPresenter()->flashMessage('The new record is saved', 'success');
        }

        if ($values->id !== '') {
            $scheduleDetail = $this->scheduleDetailRepository->getById((int) $values->id);

            $scheduleDetail->setSchedule($schedule);
            $scheduleDetail->setEventDate(DateTime::createFromFormat('Y-m-d\TH:i', $values->event_date));
            $scheduleDetail->setDiscipline($discipline);

            $this->scheduleDetailRepository->save($scheduleDetail);
            $this->getPresenter()->flashMessage('The record is updated', 'info');
        }

        $this->scheduleId = $values->schedule_id;

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/scheduleDetailForm.latte');
        $template->render();
    }

    public function getScheduleId(): int
    {
        return $this->scheduleId;
    }
}