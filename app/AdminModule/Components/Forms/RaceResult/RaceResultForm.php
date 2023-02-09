<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RaceResult;

use App\Model\Entities\RaceResult\RaceResult;
use App\Model\Repositories\DriverRepository;
use App\Model\Repositories\RaceResultRepository;
use App\Model\Repositories\ScheduleRepository;
use App\Model\Repositories\ScoreSystemRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class RaceResultForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private int $scheduleId;

    private ScheduleRepository $scheduleRepository;

    private DriverRepository $driverRepository;

    private ScoreSystemRepository $scoreSystemRepository;

    private RaceResultRepository $raceResultRepository;

    public function __construct(
        ScheduleRepository $scheduleRepository,
        DriverRepository $driverRepository,
        ScoreSystemRepository $scoreSystemRepository,
        RaceResultRepository $raceResultRepository
    )
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->driverRepository = $driverRepository;
        $this->scoreSystemRepository = $scoreSystemRepository;
        $this->raceResultRepository = $raceResultRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('schedule_id', 'Schedule', $this->scheduleRepository->findAllForSelectBox())
             ->setPrompt('--Choose schedule--')
             ->setRequired('The schedule is required');

        $form->addSelect('driver_id', 'Driver', $this->driverRepository->findAllForSelectBox())
             ->setPrompt('--Choose driver--')
             ->setRequired('The driver is required');

        $form->addSelect('score_system_id', 'Score System', $this->scoreSystemRepository->findAllForSelectBox())
             ->setPrompt('--Choose score system--')
             ->setRequired('The score system is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        $schedule = $this->scheduleRepository->getById((int) $values->schedule_id);
        $driver = $this->driverRepository->getById((int) $values->driver_id);
        $scoreSystem = $this->scoreSystemRepository->getById((int) $values->score_system_id);

        if ($values->id === '') {
            $raceResult = new RaceResult(
                $schedule,
                $driver,
                $scoreSystem
            );

            $this->raceResultRepository->save($raceResult);
            $this->getPresenter()->flashMessage('The new result is saved', 'success');
        }

        if ($values->id !== '') {
            $raceResult = $this->raceResultRepository->getById((int) $values->id);

            $raceResult->setSchedule($schedule);
            $raceResult->setDriver($driver);
            $raceResult->setScoreSystem($scoreSystem);

            $this->raceResultRepository->save($raceResult);
            $this->getPresenter()->flashMessage('The result record is updated', 'info');
        }

        $this->scheduleId = $values->schedule_id;

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/raceResultForm.latte');
        $template->render();
    }

    public function getScheduleId(): int
    {
        return $this->scheduleId;
    }


}