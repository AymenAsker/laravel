<?php

namespace App\Repositories\Admin;

use App\Base\Repositories\Repository;
use App\Models\Category;

class CategoryRepository extends Repository
{
    public function __construct(Category $category)
    {
        $this->setModel($category);
    }
}
