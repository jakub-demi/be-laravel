<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CategoryService
{
    public function store(array $data): Model|Builder
    {
        return Category::create($data);
    }

    public function update(int $id, array $data): Model|Builder
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete(int $id): string
    {
        $category = Category::findOrFail($id);
        $categoryName = $category->name;
        $category->delete();
        return $categoryName;
    }
}
