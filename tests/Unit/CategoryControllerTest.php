<?php

namespace Tests\Unit;

use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;

class CategoryControllerTest extends TestCase {

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_getProducts_returns_expected_json_structure(): void
    {
        $productRepository = Mockery::mock(ProductRepository::class);

        $product = Product::factory()->makeOne([
            'id' => 1,
            'parent_id' => 10,
            'product_name' => 'Sample Product',
            'slug' => 'sample-product',
            'product_type_id' => 2,
            'status_id' => 3,
        ]);
        $products = new LengthAwarePaginator(
            [$product],
            1,
            12,
            1
        );

        $productRepository
            ->shouldReceive('getByModel')
            ->once()
            ->with(Category::class, 123, ['variations', 'variations.productImages', 'productCategories', 'productType', 'status'])
            ->andReturn($products);

        $controller = new CategoryController($productRepository);

        $response = $controller->getProducts(123);
        $decodedResponse = json_decode($response, true);

        $this->assertIsArray($decodedResponse);
        $this->assertArrayHasKey('data', $decodedResponse);
        $this->assertArrayHasKey('products', $decodedResponse['data']);
        $this->assertSame(1, $decodedResponse['data']['products']['total']);
        $this->assertSame(12, $decodedResponse['data']['products']['per_page']);
        $this->assertCount(1, $decodedResponse['data']['products']['data']);
        $this->assertEquals([
            'id' => 1,
            'parent_id' => 10,
            'product_name' => 'Sample Product',
            'slug' => 'sample-product',
            'product_type_id' => 2,
            'status_id' => 3,
        ], $decodedResponse['data']['products']['data'][0]);
    }

    public function test_getProducts_returns_empty_products_array_when_repository_throws_exception(): void
    {
        $productRepository = Mockery::mock(ProductRepository::class);

        $productRepository
            ->shouldReceive('getByModel')
            ->once()
            ->with(Category::class, 123, ['variations', 'variations.productImages', 'productCategories', 'productType', 'status'])
            ->andThrow(new Exception('Repository failure'));

        $controller = new CategoryController($productRepository);

        $response = $controller->getProducts(123);
        $decodedResponse = json_decode($response, true);

        $this->assertSame([
            'data' => [
                'products' => [],
                'error' => 'Repository failure',
            ],
        ], $decodedResponse);
    }
}
