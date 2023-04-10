<?php

namespace App\Repositories\Provider;

use App\Base\Repositories\Repository;
use App\Models\Category;
use App\Models\ProviderService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class  ProviderServiceRepository extends Repository
{
    public function __construct(ProviderService $providerService)
    {
        $this->setModel($providerService);
    }
}
