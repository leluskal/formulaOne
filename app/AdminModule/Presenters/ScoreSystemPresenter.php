<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\ScoreSystem\ScoreSystemForm;
use App\AdminModule\Components\Forms\ScoreSystem\ScoreSystemFormFactory;
use App\Model\Repositories\ScoreSystemRepository;
use App\Presenters\BasePresenter;

class ScoreSystemPresenter extends BasePresenter
{
    private ScoreSystemRepository $scoreSystemRepository;

    private ScoreSystemFormFactory $scoreSystemFormFactory;

    public function __construct(ScoreSystemRepository $scoreSystemRepository, ScoreSystemFormFactory $scoreSystemFormFactory)
    {
        $this->scoreSystemRepository = $scoreSystemRepository;
        $this->scoreSystemFormFactory = $scoreSystemFormFactory;
    }

    public function createComponentScoreSystemForm(): ScoreSystemForm
    {
        $form = $this->scoreSystemFormFactory->create();

        $form->onFinish[] = function (ScoreSystemForm $scoreSystemForm) {
            $this->redirect('ScoreSystem:default');
        };

        return $form;
    }

    public function renderDefault()
    {
        $this->template->scoreSystems = $this->scoreSystemRepository->findAll();
    }

    public function renderEdit(int $id)
    {
        $scoreSystem = $this->scoreSystemRepository->getById($id);

        $this['scoreSystemForm']['form']['id']->setDefaultValue($scoreSystem->getId());
        $this['scoreSystemForm']['form']['position']->setDefaultValue($scoreSystem->getPosition());
        $this['scoreSystemForm']['form']['points']->setDefaultValue($scoreSystem->getPoints());
    }

    public function renderCreate()
    {

    }

    public function handleDeleteScoreSystem(int $id)
    {
        $scoreSystem = $this->scoreSystemRepository->getById($id);

        $this->scoreSystemRepository->delete($scoreSystem);
        $this->flashMessage('The new record is saved', 'success');
        $this->redirect('ScoreSystem:default');
    }


}