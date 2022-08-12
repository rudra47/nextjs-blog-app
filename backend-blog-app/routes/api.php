<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Post;

Route::get('/posts', function (){
    $posts = Post::all();
    return response()->json($posts);
});
