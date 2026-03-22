<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Status;
use App\Repositories\CategoryRepository;
use App\Repositories\FileRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductTypeRepository;
use App\Repositories\StatusRepository;
use App\Repositories\VariationRepository;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

#[Signature('ImportProducts')]
#[Description('Command description')]
class ImportProducts extends Command
{

    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly StatusRepository $statusRepository,
        private readonly ProductTypeRepository $productTypeRepository,
        private readonly VariationRepository $variationRepository,
        private readonly FileRepository $fileRepository,
        private readonly CategoryRepository $categoryRepository
    ) {
        parent::__construct();

    }

    /**
     * Execute the console command.
     */
    public function handle()
    {   

        $json = Storage::disk('local')->get('products.json');
        $json = json_decode($json, true);

        $products = $json['hits'];
 
        foreach($products as $product){
            DB::beginTransaction();
            $newProduct = $this->createProduct($product);

            $variations = $this->createVariations($newProduct->id, $product['variations']);

            $productCategories = $this->createProductCategories($product['product_categories']);
            $newProduct->productCategories()->sync($productCategories);
            DB::commit();
        }
    }

    public function createProduct($product): Product
    {
        $productAttributes = [
            'parent_id' => $product['parent_id'],
            'product_name' => $product['product_name'],
            'slug' => $product['slug'],
            'product_type_id' => $this->getOrCreateProductType($product['product_type'])->id,
            'status_id' => $this->getOrCreateStatus($product['status'])->id
        ];

        return $this->productRepository->create($productAttributes);
    }

    public function createVariations(int $productId, $variations)
    {
        $variationsCollection = new Collection();

        foreach($variations as $variation) {
            $variationAttributes = [
                'sku_id' => $variation['sku_id'],
                'product_id' => $productId
            ];

            $newVariation = $this->variationRepository->create($variationAttributes);
            $productImages = $this->createFiles($newVariation->id, $variation['product_images']);

            $variationsCollection->add($newVariation);
        }

        return $variationsCollection;
    }

    public function createFiles(int $variationId, $files)
    {
        $filesCollection = new Collection();

        foreach($files as $file) {
            $fileAttributes = [
                'filename' => $file['filename'],
                'variation_id' => $variationId
            ];

            $fileModel = $this->fileRepository->create($fileAttributes);
            $filesCollection->add($fileModel);
        }

        return $filesCollection;
    }

    public function createProductCategories($productCategories)
    {
        $productCategoriesCollection = new Collection();

        foreach($productCategories as $productCategory) {
            $categoryAtributes = [
                'id' => $productCategory['id'],
                'name' => $productCategory['name']
            ];
            $category = $this->getOrCreateCategory(...$categoryAtributes);
            $productCategoriesCollection->add($category);
        }

        return $productCategoriesCollection;
    }

    public function getOrCreateCategory(int $id, string $name): Category 
    {
        $category = $this->categoryRepository->get($id);

        if($category){
            return $category;
        }

        return $this->categoryRepository->create([
            'id' => $id,
            'name' => $name
        ]);
    }

    public function getOrCreateStatus(string $statusName): Status
    {
        $status = $this->statusRepository->getByName($statusName);

        if($status){
            return $status;
        }

        return $this->statusRepository->create([
            'name' => $statusName
        ]);
    }

    public function getOrCreateProductType(string $productTypeName): ProductType
    {
        $productType = $this->productTypeRepository->getByName($productTypeName);

        if($productType){
            return $productType;
        }

        return $this->productTypeRepository->create([
            'name' => $productTypeName
        ]);
    }
}
