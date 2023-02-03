<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Driver;

use App\Model\Entities\Driver\Driver;
use App\Model\Repositories\DriverRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class DriverForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private DriverRepository $driverRepository;

    public function __construct(DriverRepository $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('firstname', 'Firstname')
             ->setRequired('The firstname is required');

        $form->addText('lastname', 'Lastname')
             ->setRequired('The lastname is required');

        $form->addText('country', 'Country')
             ->setRequired('The country is required');

        $form->addInteger('number_of_podiums', 'Number Of Podiums')
             ->setRequired('The number of podiums is required');

        $form->addInteger('number_of_points', 'Number Of Points')
             ->setRequired('The number of points is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->id === '') {
            $driver = new Driver(
                $values->firstname,
                $values->lastname,
                $values->country,
                $values->number_of_podiums,
                $values->number_of_points
            );

            $this->driverRepository->save($driver);
            $this->getPresenter()->flashMessage('The new driver is saved', 'success');
        }

        if ($values->id !== '') {
            $driver = $this->driverRepository->getById((int) $values->id);

            $driver->setFirstname($values->firstname);
            $driver->setLastname($values->lastname);
            $driver->setCountry($values->country);
            $driver->setNumberOfPodiums($values->number_of_podiums);
            $driver->setNumberOfPoints($values->number_of_points);

            $this->driverRepository->save($driver);
            $this->getPresenter()->flashMessage('The driver record is updated', 'info');
        }

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/driverForm.latte');
        $template->render();
    }

}