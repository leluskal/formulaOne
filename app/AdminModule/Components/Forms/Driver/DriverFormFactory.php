<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Driver;

use App\Model\Repositories\DriverRepository;

class DriverFormFactory
{
    private DriverRepository $driverRepository;

    public function __construct(DriverRepository $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    public function create(): DriverForm
    {
        return new DriverForm($this->driverRepository);
    }
}