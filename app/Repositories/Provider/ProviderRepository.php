<?php

namespace App\Repositories\Provider;

use App\Base\Repositories\Repository;
use App\Models\Provider;

class  ProviderRepository extends Repository
{
    public function __construct(Provider $provider)
    {
        $this->setModel($provider);
    }
}
