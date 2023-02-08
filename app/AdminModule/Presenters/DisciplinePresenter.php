<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Discipline\DisciplineForm;
use App\AdminModule\Components\Forms\Discipline\DisciplineFormFactory;
use App\Model\Repositories\DisciplineRepository;
use App\Presenters\BasePresenter;

class DisciplinePresenter extends BasePresenter
{
    private DisciplineRepository $disciplineRepository;

    private DisciplineFormFactory $disciplineFormFactory;

    public function __construct(
        DisciplineRepository $disciplineRepository,
        DisciplineFormFactory $disciplineFormFactory
    )
    {
        $this->disciplineRepository = $disciplineRepository;
        $this->disciplineFormFactory = $disciplineFormFactory;
    }

    public function createComponentDisciplineForm(): DisciplineForm
    {
        $form = $this->disciplineFormFactory->create();

        $form->onFinish[] = function (DisciplineForm $disciplineForm) {
            $this->redirect('Discipline:default');
        };

        return $form;
    }

    public function renderDefault()
    {
        $this->template->disciplines = $this->disciplineRepository->findAll();
    }

    public function renderEdit(int $id)
    {
        $discipline = $this->disciplineRepository->getById($id);

        $this['disciplineForm']['form']['id']->setDefaultValue($discipline->getId());
        $this['disciplineForm']['form']['name']->setDefaultValue($discipline->getName());
    }

    public function renderCreate()
    {

    }

    public function handleDeleteDiscipline(int $id)
    {
        $discipline = $this->disciplineRepository->getById($id);

        $this->disciplineRepository->delete($discipline);
        $this->getPresenter()->flashMessage('The discipline record is deleted', 'info');
        $this->redirect('Discipline:default');
    }

}