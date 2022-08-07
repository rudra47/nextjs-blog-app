<?php

namespace App\Repositories;


use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Services\Summernote\SummernoteImageService;
use App\Services\Utils\FileUploadService;
use Illuminate\Support\Str;

class ProductRepository implements ProductRepositoryInterface {

    protected $summernoteImageService;
    protected $fileUploadService;

    public function __construct(SummernoteImageService $summernoteImageService, FileUploadService $fileUploadService)
    {
        $this->summernoteImageService = $summernoteImageService;
        $this->fileUploadService = $fileUploadService;
    }

    public function getProduct($productType = null) {
        return Product::with('store')
            ->when($productType, function ($query) use($productType){
                if ($productType == 'trending_now')
                    $query->where('trending_now', 1);
                if ($productType == 'favorite_today')
                    $query->where('favorite_today', 1);
            })->latest()->get();
    }

    public function getProductById($id) {
        return Product::findOrFail($id);
    }

    public function deleteProduct($id) {
        $product = Product::findOrFail($id);
        try {
            $this->fileUploadService->delete(Product::FILE_STORE_PATH.'/'.$product->image);
        }catch (\Exception $e) {}
        $product->delete();
        return $product;
    }

    public function createProduct($request) {

        $image_name = null;

        if ($request->image) {
            $image_name = $this->fileUploadService->uploadFile($request->image, Product::FILE_STORE_PATH, null);
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'store_id' => $request->store_id,
            'regular_price' => $request->regular_price,
            'price' => $request->price,
            'image' => $image_name,
            'short_description' => $request->short_description,
            'description' => $this->summernoteImageService->dom_document($request->description),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
        ]);

        if($request->category_ids) {
            $product->categories()->attach($request->category_ids);
        }

        if($request->tags) {
            $product->tags()->attach($request->tags);
        }

        return $product;
    }

    public function updateProduct($product, $request) {
        $image_name = null;

        if ($request->image) {
            $image_name = $this->fileUploadService->uploadFile($request->image, Product::FILE_STORE_PATH, Product::FILE_STORE_PATH.'/'.$product->image);
        }else{
            $image_name = $product->image;
        }

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->store_id = $request->store_id;
        $product->regular_price = $request->regular_price;
        $product->price = $request->price;
        $product->image = $image_name;
        $product->short_description = $request->short_description;
        $product->description = $this->summernoteImageService->dom_document($request->description);
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->trending_now = $request->trending_now ?? 0;
        $product->favorite_today = $request->favorite_today ?? 0;
        $product->status = $request->status;
        $product->save();

        if($request->category_ids) {
            $product->categories()->sync($request->category_ids);
        }

        if($request->tags) {
            $product->tags()->sync($request->tags);
        }

        return $product;
    }
}
