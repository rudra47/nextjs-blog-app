<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function singleProduct($productSlug)
    {
        $product = Product::where('slug', $productSlug)->first();

        return response()->json($product);
    }

    public function categoryProduct($categorySlug)
    {
        $category = Category::with(['products' => function ($query) {
            $query->latest();
        }])->where('slug', $categorySlug)
        ->first();

        return response()->json($category);
    }
}
