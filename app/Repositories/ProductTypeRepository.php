<?php

namespace App\Repositories;

use App\Models\ProductType;

class ProductTypeRepository extends AbstractRepository {

    public $model = ProductType::class;
    
    public function getByName($name): ?ProductType
    {
        return $this->model::where('name', $name)->first();
    }
}