<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Chief;

use App\Model\Repositories\ChiefRepository;

class ChiefFormFactory
{
    private ChiefRepository $chiefRepository;

    public function __construct(ChiefRepository $chiefRepository)
    {
        $this->chiefRepository = $chiefRepository;
    }

    public function create(): ChiefForm
    {
        return new ChiefForm($this->chiefRepository);
    }
}