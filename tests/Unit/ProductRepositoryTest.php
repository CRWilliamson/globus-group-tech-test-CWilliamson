<?php

namespace Tests\Unit;

use App\Enums\Statuses;
use App\Repositories\ProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase {

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_getByModel_returns_a_length_aware_paginator(): void
    {
        $repository = new ProductRepository();
        $paginator = new LengthAwarePaginator([], 0, 12, 1);

        $ownerQuery = Mockery::mock();
        $owner = Mockery::mock();
        $productsQuery = Mockery::mock();

        FakeProductRepositoryModel::$ownerQuery = $ownerQuery;

        $ownerQuery
            ->shouldReceive('first')
            ->once()
            ->andReturn($owner);

        $owner
            ->shouldReceive('products')
            ->once()
            ->andReturn($productsQuery);

        $productsQuery
            ->shouldReceive('with')
            ->once()
            ->with('status')
            ->andReturnSelf();

        $productsQuery
            ->shouldReceive('where')
            ->once()
            ->with('status_id', '!=', Statuses::DISCONTINUED)
            ->andReturnSelf();

        $productsQuery
            ->shouldReceive('paginate')
            ->once()
            ->with(12)
            ->andReturn($paginator);

        $result = $repository->getByModel(FakeProductRepositoryModel::class, 123, ['status']);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    public function test_getByModel_does_not_include_discontinued_products_when_includeDiscontinued_is_false(): void
    {
        $repository = new ProductRepository();
        $paginator = new LengthAwarePaginator([], 0, 12, 1);

        $ownerQuery = Mockery::mock();
        $owner = Mockery::mock();
        $productsQuery = Mockery::mock();

        FakeProductRepositoryModel::$ownerQuery = $ownerQuery;

        $ownerQuery
            ->shouldReceive('first')
            ->once()
            ->andReturn($owner);

        $owner
            ->shouldReceive('products')
            ->once()
            ->andReturn($productsQuery);

        $productsQuery
            ->shouldReceive('with')
            ->once()
            ->withNoArgs()
            ->andReturnSelf();

        $productsQuery
            ->shouldReceive('where')
            ->once()
            ->with('status_id', '!=', Statuses::DISCONTINUED)
            ->andReturnSelf();

        $productsQuery
            ->shouldReceive('paginate')
            ->once()
            ->with(12)
            ->andReturn($paginator);

        $result = $repository->getByModel(FakeProductRepositoryModel::class, 456, [], false);

        $this->assertSame($paginator, $result);
    }

    public function test_getByModel_does_include_discontinued_products_when_includeDiscontinued_is_true(): void
    {
        $repository = new ProductRepository();
        $paginator = new LengthAwarePaginator([], 0, 12, 1);

        $ownerQuery = Mockery::mock();
        $owner = Mockery::mock();
        $productsQuery = Mockery::mock();

        FakeProductRepositoryModel::$ownerQuery = $ownerQuery;

        $ownerQuery
            ->shouldReceive('first')
            ->once()
            ->andReturn($owner);

        $owner
            ->shouldReceive('products')
            ->once()
            ->andReturn($productsQuery);

        $productsQuery
            ->shouldReceive('with')
            ->once()
            ->with('productType')
            ->andReturnSelf();

        $productsQuery
            ->shouldNotReceive('where');

        $productsQuery
            ->shouldReceive('paginate')
            ->once()
            ->with(12)
            ->andReturn($paginator);

        $result = $repository->getByModel(FakeProductRepositoryModel::class, 789, ['productType'], true);

        $this->assertSame($paginator, $result);
    }
}

class FakeProductRepositoryModel
{
    public static mixed $ownerQuery;

    public static function where(string $column, int $id): mixed
    {
        return static::$ownerQuery;
    }
}
