<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Schedule\ScheduleForm;
use App\AdminModule\Components\Forms\Schedule\ScheduleFormFactory;
use App\Model\Repositories\ScheduleDetailRepository;
use App\Model\Repositories\ScheduleRepository;
use App\Presenters\BasePresenter;

class SchedulePresenter extends BasePresenter
{
    private ScheduleRepository $scheduleRepository;

    private ScheduleFormFactory $scheduleFormFactory;

    private ScheduleDetailRepository $scheduleDetailRepository;

    public function __construct(
        ScheduleRepository $scheduleRepository,
        ScheduleFormFactory $scheduleFormFactory,
        ScheduleDetailRepository $scheduleDetailRepository
    )
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->scheduleFormFactory = $scheduleFormFactory;
        $this->scheduleDetailRepository = $scheduleDetailRepository;
    }

    public function createComponentScheduleForm(): ScheduleForm
    {
        $form = $this->scheduleFormFactory->create();

        $form->onFinish[] = function (ScheduleForm $scheduleForm) {
            $this->redirect('Schedule:default');
        };

        return $form;
    }

    public function renderDefault()
    {
        $this->template->schedules = $this->scheduleRepository->findAllByYear((int) $this->year);
        $this->template->year = $this->year;
    }

    public function renderEdit(int $id)
    {
        $schedule = $this->scheduleRepository->getById($id);

        $this['scheduleForm']['form']['id']->setDefaultValue($schedule->getId());
        $this['scheduleForm']['form']['date_from']->setDefaultValue($schedule->getDateFrom()->format('Y-m-d'));
        $this['scheduleForm']['form']['date_to']->setDefaultValue($schedule->getDateTo()->format('Y-m-d'));
        $this['scheduleForm']['form']['name']->setDefaultValue($schedule->getName());
        $this['scheduleForm']['form']['year']->setDefaultValue($schedule->getYear());
    }

    public function renderCreate(int $year)
    {
        $this['scheduleForm']['form']['year']->setDefaultValue($year);
    }

    public function handleDeleteSchedule(int $id)
    {
        $schedule = $this->scheduleRepository->getById($id);

        $this->scheduleRepository->delete($schedule);
        $this->flashMessage('The schedule record is deleted', 'info');
        $this->redirect('Schedule:default');
    }

    public function renderDetail(int $scheduleId)
    {
        $this->template->schedule = $this->scheduleRepository->getById($scheduleId);
        $this->template->scheduleDetails = $this->scheduleDetailRepository->findAllByScheduleId($scheduleId);
    }
}