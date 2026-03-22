<?php

namespace App\Repositories;

use App\Enums\Statuses;
use App\Models\Category;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use InvalidArgumentException;

class ProductRepository extends AbstractRepository {

    public $model = Product::class;

    /**
     * @param $productRelations array<int,string>
     */
    public function getByModel(string $modelClass, int $modelId, array $productRelations = [], bool $includeDiscontinued = false): LengthAwarePaginator
    {
        $productsQuery = $modelClass::where('id', $modelId)->first()->products()->with(...$productRelations);
        
        if(!$includeDiscontinued){
            $productsQuery->where('status_id', '!=', Statuses::DISCONTINUED);
        }
        
        $products = $productsQuery->paginate(12);
        return $products;
    }
}