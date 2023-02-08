<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\ScoreSystem;

use App\Model\Repositories\ScoreSystemRepository;

class ScoreSystemFormFactory
{
    private ScoreSystemRepository $scoreSystemRepository;

    public function __construct(ScoreSystemRepository $scoreSystemRepository)
    {
        $this->scoreSystemRepository = $scoreSystemRepository;
    }

    public function create(): ScoreSystemForm
    {
        return new ScoreSystemForm($this->scoreSystemRepository);
    }
}