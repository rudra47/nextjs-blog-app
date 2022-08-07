<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAllCategory();
    public function getCategoryById($id);
    public function deleteCategory($id);
    public function createCategory($request);
    public function updateCategory($id, $request);
}
