<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\ScheduleDetail\ScheduleDetailForm;
use App\AdminModule\Components\Forms\ScheduleDetail\ScheduleDetailFormFactory;
use App\Model\Repositories\ScheduleDetailRepository;
use App\Presenters\BasePresenter;

class ScheduleDetailPresenter extends BasePresenter
{
    private ScheduleDetailRepository $scheduleDetailRepository;

    private ScheduleDetailFormFactory $scheduleDetailFormFactory;

    public function __construct(
        ScheduleDetailRepository $scheduleDetailRepository,
        ScheduleDetailFormFactory $scheduleDetailFormFactory
    )
    {
        $this->scheduleDetailRepository = $scheduleDetailRepository;
        $this->scheduleDetailFormFactory = $scheduleDetailFormFactory;
    }

    public function createComponentScheduleDetailForm(): ScheduleDetailForm
    {
        $form = $this->scheduleDetailFormFactory->create();

        $form->onFinish[] = function (ScheduleDetailForm $scheduleDetailForm) use ($form) {
            $this->redirect('Schedule:detail', ['scheduleId' => $form->getScheduleId()]);
        };

        return $form;
    }

    public function renderEdit(int $id)
    {
        $scheduleDetail = $this->scheduleDetailRepository->getById($id);
        $schedule = $scheduleDetail->getSchedule()->getId();
        $discipline = $scheduleDetail->getDiscipline()->getId();

        $this['scheduleDetailForm']['form']['id']->setDefaultValue($scheduleDetail->getId());
        $this['scheduleDetailForm']['form']['schedule_id']->setDefaultValue($schedule);
        $this['scheduleDetailForm']['form']['event_date']->setDefaultValue($scheduleDetail->getEventDate()->format('Y-m-d\TH:i'));
        $this['scheduleDetailForm']['form']['discipline_id']->setDefaultValue($discipline);
    }

    public function renderCreate(int $scheduleId)
    {
        $this['scheduleDetailForm']['form']['schedule_id']->setDefaultValue($scheduleId);
    }

}