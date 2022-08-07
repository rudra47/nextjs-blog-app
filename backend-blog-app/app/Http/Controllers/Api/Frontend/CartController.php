<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Interfaces\CartRepositoryInterface;
use App\Models\Package;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class CartController extends Controller
{

    public function cartProducts(Request $request, CartRepositoryInterface $cartRepository): JsonResponse
    {
        return $cartRepository->getCartProducts($request);

    }

}
