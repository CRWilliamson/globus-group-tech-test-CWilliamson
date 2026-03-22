<?php

namespace App\Repositories;

use App\Models\Status;

class StatusRepository extends AbstractRepository{

    public $model = Status::class;

    public function getByName($name): ?Status
    {
        return $this->model::where('name', $name)->first();
    }
}