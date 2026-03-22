<?php

namespace Tests\Feature;

use App\Enums\Statuses;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Status;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase {

    use RefreshDatabase;

    public function test_getByModel_returns_a_length_aware_paginator(): void
    {
        $repository = new ProductRepository();
        $category = Category::create(['name' => 'Eye Protection']);
        $productType = ProductType::create(['name' => 'Glasses']);

        $this->createStatuses();

        $product = Product::factory()->create([
            'parent_id' => 'parent-1',
            'product_name' => 'Safety Glasses',
            'slug' => 'safety-glasses',
            'product_type_id' => $productType->id,
            'status_id' => 1,
        ]);

        $category->products()->attach($product->id);

        $result = $repository->getByModel(Category::class, $category->id, ['status']);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame(1, $result->total());
        $this->assertCount(1, $result->items());
        $this->assertSame($product->id, $result->items()[0]->id);
    }

    public function test_getByModel_does_not_include_discontinued_products_if_includeDiscontinued_is_false(): void
    {
        $repository = new ProductRepository();
        $category = Category::create(['name' => 'Hand Protection']);
        $productType = ProductType::create(['name' => 'Gloves']);

        $this->createStatuses();

        $activeProduct = Product::factory()->create([
            'parent_id' => 'parent-2',
            'product_name' => 'Work Gloves',
            'slug' => 'work-gloves',
            'product_type_id' => $productType->id,
            'status_id' => 1,
        ]);

        $discontinuedProduct = Product::factory()->create([
            'parent_id' => 'parent-3',
            'product_name' => 'Old Gloves',
            'slug' => 'old-gloves',
            'product_type_id' => $productType->id,
            'status_id' => Statuses::DISCONTINUED->value,
        ]);

        $category->products()->attach([$activeProduct->id, $discontinuedProduct->id]);

        $result = $repository->getByModel(Category::class, $category->id, ['status'], false);
        $productIds = collect($result->items())->pluck('id')->all();

        $this->assertSame(1, $result->total());
        $this->assertSame([$activeProduct->id], $productIds);
        $this->assertNotContains($discontinuedProduct->id, $productIds);
    }

    public function test_getByModel_does_include_discontinued_products_if_includeDiscontinued_is_true(): void
    {
        $repository = new ProductRepository();
        $category = Category::create(['name' => 'Head Protection']);
        $productType = ProductType::create(['name' => 'Helmets']);

        $this->createStatuses();

        $activeProduct = Product::factory()->create([
            'parent_id' => 'parent-4',
            'product_name' => 'Site Helmet',
            'slug' => 'site-helmet',
            'product_type_id' => $productType->id,
            'status_id' => 1,
        ]);

        $discontinuedProduct = Product::factory()->create([
            'parent_id' => 'parent-5',
            'product_name' => 'Legacy Helmet',
            'slug' => 'legacy-helmet',
            'product_type_id' => $productType->id,
            'status_id' => Statuses::DISCONTINUED->value,
        ]);

        $category->products()->attach([$activeProduct->id, $discontinuedProduct->id]);

        $result = $repository->getByModel(Category::class, $category->id, ['status'], true);
        $productIds = collect($result->items())->pluck('id')->sort()->values()->all();

        $this->assertSame(2, $result->total());
        $this->assertSame(
            [$activeProduct->id, $discontinuedProduct->id],
            $productIds
        );
    }

    private function createStatuses(): void
    {
        Status::factory()->create([
            'id' => 1,
            'name' => 'Active',
        ]);

        Status::factory()->create([
            'id' => 2,
            'name' => 'Draft',
        ]);

        Status::factory()->create([
            'id' => Statuses::DISCONTINUED->value,
            'name' => 'Discontinued',
        ]);
    }
}
