<?php

namespace App\Repositories;

use App\Interfaces\TagRepositoryInterface;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagRepository implements TagRepositoryInterface {

    public function getAllTag() {
        return Tag::all();
    }

    public function getTagById($id) {
        return Tag::findOrFail($id);
    }

    public function deleteTag($id) {
        return Tag::destroy($id);
    }

    public function createTag($request) {
        return Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
    }

    public function updateTag($id, $request) {
        $tag = Tag::findOrFail($id);
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name);
        $tag->save();
        return $tag;
    }
}
