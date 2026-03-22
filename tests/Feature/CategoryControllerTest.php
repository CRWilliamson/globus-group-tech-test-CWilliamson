<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase {

    use RefreshDatabase;

    public function test_getProducts_returns_products_for_the_requested_category(): void
    {
        $productType = ProductType::create(['name' => 'Glasses']);
        $status = Status::create(['name' => 'Active']);
        $category = Category::create(['name' => 'Safety']);

        $product = Product::factory()->create([
            'parent_id' => 'parent-1',
            'product_name' => 'Protective Goggles',
            'slug' => 'protective-goggles',
            'product_type_id' => $productType->id,
            'status_id' => $status->id,
        ]);

        $category->products()->attach($product->id);

        $response = $this->get("/api/categories/{$category->id}/products");
        $payload = json_decode($response->getContent(), true);

        $response->assertOk();
        $this->assertSame(1, $payload['data']['products']['total']);
        $this->assertSame(12, $payload['data']['products']['per_page']);
        $this->assertCount(1, $payload['data']['products']['data']);
        $this->assertSame($product->id, $payload['data']['products']['data'][0]['id']);
        $this->assertSame('Protective Goggles', $payload['data']['products']['data'][0]['product_name']);
        $this->assertSame('protective-goggles', $payload['data']['products']['data'][0]['slug']);
        $this->assertSame([], $payload['data']['products']['data'][0]['variations']);
        $this->assertSame('Safety', $payload['data']['products']['data'][0]['product_categories'][0]['name']);
        $this->assertSame('Glasses', $payload['data']['products']['data'][0]['product_type']['name']);
        $this->assertSame('Active', $payload['data']['products']['data'][0]['status']['name']);
    }

    public function test_getProducts_only_returns_products_attached_to_the_requested_category(): void
    {
        $productType = ProductType::create(['name' => 'Gloves']);
        $status = Status::create(['name' => 'Active']);
        $targetCategory = Category::create(['name' => 'Hand Protection']);
        $otherCategory = Category::create(['name' => 'Eye Protection']);

        $includedProduct = Product::factory()->create([
            'parent_id' => 'parent-2',
            'product_name' => 'Cut Resistant Glove',
            'slug' => 'cut-resistant-glove',
            'product_type_id' => $productType->id,
            'status_id' => $status->id,
        ]);

        $excludedProduct = Product::factory()->create([
            'parent_id' => 'parent-3',
            'product_name' => 'Face Shield',
            'slug' => 'face-shield',
            'product_type_id' => $productType->id,
            'status_id' => $status->id,
        ]);

        $targetCategory->products()->attach($includedProduct->id);
        $otherCategory->products()->attach($excludedProduct->id);

        $response = $this->get("/api/categories/{$targetCategory->id}/products");
        $payload = json_decode($response->getContent(), true);

        $response->assertOk();
        $this->assertSame(1, $payload['data']['products']['total']);
        $this->assertCount(1, $payload['data']['products']['data']);
        $this->assertSame($includedProduct->id, $payload['data']['products']['data'][0]['id']);
        $this->assertSame('Cut Resistant Glove', $payload['data']['products']['data'][0]['product_name']);
    }
}
