<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Chief;

use App\Model\Entities\Chief\Chief;
use App\Model\Repositories\ChiefRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class ChiefForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private ChiefRepository $chiefRepository;

    public function __construct(ChiefRepository $chiefRepository)
    {
        $this->chiefRepository = $chiefRepository;
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

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->id === '') {
            $chief = new Chief(
                $values->firstname,
                $values->lastname,
                $values->country
            );

            $this->chiefRepository->save($chief);
            $this->getPresenter()->flashMessage('The new chief is saved', 'success');
        }

        if ($values->id !== '') {
            $chief = $this->chiefRepository->getById((int) $values->id);

            $chief->setFirstname($values->firstname);
            $chief->setLastname($values->lastname);
            $chief->setCountry($values->country);

            $this->chiefRepository->save($chief);
            $this->getPresenter()->flashMessage('The chief record is updated', 'info');
        }

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/chiefForm.latte');
        $template->render();
    }
}