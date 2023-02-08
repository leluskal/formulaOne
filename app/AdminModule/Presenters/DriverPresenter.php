<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Driver\DriverForm;
use App\AdminModule\Components\Forms\Driver\DriverFormFactory;
use App\Model\Repositories\DriverRepository;
use App\Presenters\BasePresenter;

class DriverPresenter extends BasePresenter
{
    private DriverRepository $driverRepository;

    private DriverFormFactory $driverFormFactory;

    public function __construct(DriverRepository $driverRepository, DriverFormFactory $driverFormFactory)
    {
        $this->driverRepository = $driverRepository;
        $this->driverFormFactory = $driverFormFactory;
    }

    public function createComponentDriverForm(): DriverForm
    {
        $form = $this->driverFormFactory->create();

        $form->onFinish[] = function (DriverForm $driverForm) {
            $this->redirect('Driver:default');
        };

        return $form;
    }

    public function renderDefault()
    {
        $this->template->drivers = $this->driverRepository->findAll();
    }

    public function renderEdit(int $id)
    {
        $driver = $this->driverRepository->getById($id);

        $this['driverForm']['form']['id']->setDefaultValue($driver->getId());
        $this['driverForm']['form']['firstname']->setDefaultValue($driver->getFirstname());
        $this['driverForm']['form']['lastname']->setDefaultValue($driver->getLastname());
        $this['driverForm']['form']['country']->setDefaultValue($driver->getCountry());
        $this['driverForm']['form']['number_of_podiums']->setDefaultValue($driver->getNumberOfPodiums());
        $this['driverForm']['form']['number_of_points']->setDefaultValue($driver->getNumberOfPoints());
    }

    public function renderCreate()
    {

    }

    public function handleDeleteDriver(int $id)
    {
        $driver = $this->driverRepository->getById($id);

        $this->driverRepository->delete($driver);
        $this->flashMessage('The driver record is deleted', 'info');
        $this->redirect('Driver:default');
    }


}