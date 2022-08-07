<?php

namespace App\Interfaces;

interface TagRepositoryInterface
{
    public function getAllTag();
    public function getTagById($id);
    public function deleteTag($id);
    public function createTag($request);
    public function updateTag($id, $request);
}
