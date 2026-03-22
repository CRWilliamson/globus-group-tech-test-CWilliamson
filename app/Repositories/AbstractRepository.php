<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class AbstractRepository {

    public $model = Model::class;

    public function create(array $attributes): Model
    {
        $newModel = $this->model::create($attributes);
        $newModel->save();

        return $newModel;
    }

    /**
     * @param $relations array<int,string>
     */
    public function getAll(array $relations = []): LengthAwarePaginator
    {
        if(empty($relations)){
            return $this->model::query()->paginate(12);
        }

        return $this->model::with($relations)->paginate(12);
    }

    /**
     * @param $relations array<int,string>
     */
    public function get(int $id, array $relations = []): ?Model
    {
        if(empty($relations)){
            return $this->model::where('id', $id)->first();
        }

        return $this->model::with($relations)->where('id', $id)->first();
    }
}