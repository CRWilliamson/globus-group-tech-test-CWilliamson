<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct(
        private readonly ProductRepository $productRepository
    ) {

    }

    public function getAll() {
        $products = $this->productRepository->getAll(['variations.productImages', 'productType']);

        return json_encode([
            'data' => [
                'products' => $products
            ]
        ]);
    }

    public function get(int $id) {
        $product = $this->productRepository->get($id, ['variations', 'productType', 'status']);
        return json_encode([
            'data' => [
                'product' => $product
            ]
        ]);
    }
}
