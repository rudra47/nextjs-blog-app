<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryRepositoryInterface {

    public function getAllCategory() {
        return Category::all();
    }

    public function getCategoryById($id) {
        return Category::findOrFail($id);
    }

    public function deleteCategory($id) {
        return Category::destroy($id);
    }

    public function createCategory($request) {
        return Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
    }

    public function updateCategory($id, $request) {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->save();
        return $category;
    }
}
