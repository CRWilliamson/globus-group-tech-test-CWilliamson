<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {

    }

    public function getProducts(int $id)
    {
        try {
            $products = $this->productRepository->getByModel(
                modelClass: Status::class,
                modelId: $id,
                productRelations: ['variations', 'variations.productImages', 'productCategories', 'productType', 'status'],
                includeDiscontinued: true
            );

            return json_encode([
                'data' => [
                    'products' => $products
                ]
            ]);
        } catch (Exception $e) {
            return json_encode([
                'data' => [
                    'products' => [],
                    'error' => $e->getMessage()
                ]
            ]);
        }
    }
}
