<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Chief\ChiefForm;
use App\AdminModule\Components\Forms\Chief\ChiefFormFactory;
use App\Model\Repositories\ChiefRepository;
use Nette\Application\UI\Presenter;

class ChiefPresenter extends Presenter
{
    private ChiefRepository $chiefRepository;

    private ChiefFormFactory $chiefFormFactory;

    public function __construct(ChiefRepository $chiefRepository, ChiefFormFactory $chiefFormFactory)
    {
        $this->chiefRepository = $chiefRepository;
        $this->chiefFormFactory = $chiefFormFactory;
    }

    public function createComponentChiefForm(): ChiefForm
    {
        $form = $this->chiefFormFactory->create();

        $form->onFinish[] = function (ChiefForm $chiefForm) {
            $this->redirect('Chief:default');
        };

        return $form;
    }

    public function renderDefault()
    {
        $this->template->chiefs = $this->chiefRepository->findAll();
    }

    public function renderEdit(int $id)
    {
        $chief = $this->chiefRepository->getById($id);

        $this['chiefForm']['form']['id']->setDefaultValue($chief->getId());
        $this['chiefForm']['form']['firstname']->setDefaultValue($chief->getFirstname());
        $this['chiefForm']['form']['lastname']->setDefaultValue($chief->getLastname());
        $this['chiefForm']['form']['country']->setDefaultValue($chief->getCountry());
    }

    public function renderCreate()
    {

    }

    public function handleDeleteChief(int $id)
    {
        $chief = $this->chiefRepository->getById($id);

        $this->chiefRepository->delete($chief);
        $this->flashMessage('The chief record is deleted', 'info');
        $this->redirect('Chief:default');
    }
}