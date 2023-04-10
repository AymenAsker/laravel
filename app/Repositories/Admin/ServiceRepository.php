<?php

namespace App\Repositories\Admin;

use App\Base\Repositories\Repository;
use App\Models\Service;

class ServiceRepository extends Repository
{
    public function __construct(Service $service)
    {
        $this->setModel($service);
    }
}
