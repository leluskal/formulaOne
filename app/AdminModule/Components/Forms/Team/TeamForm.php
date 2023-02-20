<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Team;

use App\Model\Entities\Team\Team;
use App\Model\Repositories\TeamRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;
use Nette\Utils\Image;

class TeamForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private TeamRepository $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Team');

        $form->addUpload('image', 'Food Image')
            ->addRule($form::IMAGE, 'Image must be JPEG, PNG, GIF or WebP.');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        /** @var FileUpload $image */
        $image = $values->image;
        $imagePath = null;

        if ($image->isImage() && $image->isOk()) {
            $fileImage =  Image::fromFile($image->getTemporaryFile());
            $imagePath =  '/img/upload/' . $image->getUntrustedName();
            $filePath = WWW_DIR . $imagePath;
            $fileImage->save($filePath);
        }

        if ($values->id === '') {
            $team = new Team(
                $values->name,
            );

            $team->setImagePath($imagePath);

            $this->teamRepository->save($team);
            $this->getPresenter()->flashMessage('The new team is saved', 'success');
        }

        if ($values->id !== '') {
            $team = $this->teamRepository->getById((int) $values->id);

            $team->setName($values->name);
            $team->setImagePath($imagePath);

            $this->teamRepository->save($team);
            $this->getPresenter()->flashMessage('The team record is updated', 'info');
        }

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/teamForm.latte');
        $template->render();
    }
}