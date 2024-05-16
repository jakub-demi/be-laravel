<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use App\Services\CacheService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll(): Collection
    {
        $cacheKey = Category::class . ".all";
        CacheService::cacheCollection($cacheKey, Category::all());

        return cache($cacheKey);
    }

    public function getById(int $id): Model|Collection|Builder|array|null
    {
        $cacheKey = Category::class . ".specific.$id";
        CacheService::cacheCollection($cacheKey, Category::find($id));

        return cache($cacheKey);
    }

    public function getAllIds(): array
    {
        return $this->getAll()->pluck("id")->toArray();
    }
}
