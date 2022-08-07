<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagProductController extends Controller
{
    public function tagProduct($tagSlug)
    {
        $tags = Tag::with(['products' => function ($query) {
            $query->latest();
        }])->where('slug', $tagSlug)->get();
        
        return response()->json($tags);
    }
}
