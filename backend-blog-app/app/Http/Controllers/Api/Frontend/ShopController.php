<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class ShopController extends Controller
{
    public function shop(Request $request)
    {
        $data['categories'] = Category::all();
        $data['categoryProducts'] = Category::with(['products' => function ($query) {
            $query->latest();
        },'products.offers'=>function($query){
            $query->where('status','active');
        }])->when($request, function ($query) use ($request){
            if (isset($request->slug))
                $query->where('slug', $request->slug);
        })->get();

//        $categories = Category::with(['products' => function ($query) {
//            $query->latest();
//        },'products.offers'=>function($query){
//            $query->where('status','active');
//        }])->get();

        return response()->json($data);
    }
}
