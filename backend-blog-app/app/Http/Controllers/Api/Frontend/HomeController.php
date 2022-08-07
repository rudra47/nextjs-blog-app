<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Interfaces\TagRepositoryInterface;
use App\Interfaces\SliderRepositoryInterface;
use App\Interfaces\PackageRepositoryInterface;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function home(TagRepositoryInterface $tagRepository, SliderRepositoryInterface $sliderRepository, ProductRepositoryInterface $productRepository, PackageRepositoryInterface $packageRepository): JsonResponse
    {

        $categories = Category::with(['products' => function ($query) {
            $query->latest();
        },'products.offers'=>function($query){
            $query->where('status','active');
        }])->get();

        return response()->json([
            'categories' => $categories,
            'packages'   => $packageRepository->getAllPackage(true),
            'sliders'    => $sliderRepository->getAllSlider(),
            'tags'       => $tagRepository->getAllTag(),
            'trending_now_products' => $productRepository->getProduct('trending_now'),
            'favorite_today_products' => $productRepository->getProduct('favorite_today')
        ]);
    }
}
