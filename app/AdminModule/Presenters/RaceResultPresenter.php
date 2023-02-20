<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\RaceResult\RaceResultForm;
use App\AdminModule\Components\Forms\RaceResult\RaceResultFormFactory;
use App\Model\Repositories\RaceResultRepository;
use App\Presenters\BasePresenter;

class RaceResultPresenter extends BasePresenter
{
    private RaceResultRepository $raceResultRepository;

    private RaceResultFormFactory $raceResultFormFactory;

    public function __construct(RaceResultRepository $raceResultRepository, RaceResultFormFactory $raceResultFormFactory)
    {
        $this->raceResultRepository = $raceResultRepository;
        $this->raceResultFormFactory = $raceResultFormFactory;
    }

    public function createComponentRaceResultForm(): RaceResultForm
    {
        $form = $this->raceResultFormFactory->create();

        $form->onFinish[] = function (RaceResultForm $raceResultForm) use ($form) {
            $this->redirect('Schedule:result', ['scheduleId' => $form->getScheduleId()]);
        };

        return $form;
    }

    public function renderEdit(int $id)
    {
        $raceResult = $this->raceResultRepository->getById($id);
        $schedule = $raceResult->getSchedule()->getId();
        $driver = $raceResult->getDriver()->getId();
        $scoreSystem = $raceResult->getScoreSystem()->getId();

        $this['raceResultForm']['form']['id']->setDefaultValue($raceResult->getId());
        $this['raceResultForm']['form']['schedule_id']->setDefaultValue($schedule);
        $this['raceResultForm']['form']['driver_id']->setDefaultValue($driver);
        $this['raceResultForm']['form']['score_system_id']->setDefaultValue($scoreSystem);
        $this['raceResultForm']['form']['year']->setDefaultValue($raceResult->getYear());
    }

    public function renderCreate(int $scheduleId)
    {
        $this['raceResultForm']['form']['schedule_id']->setDefaultValue($scheduleId);
    }
}