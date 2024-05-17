<?php

namespace App\Observers;

use App\Helpers\Helpers;
use App\Models\Category;
use App\Services\CacheService;

class CategoryObserver
{
    /**
     * Handle the Category "creating" event.
     */
    public function creating(Category $category): void
    {
        $category->slug = Helpers::generateUniqueSlug($category, $category->name);
    }

    /**
     * Handle the Category "saved" (created & updated) event.
     */
    public function saved(Category $category): void
    {
        CacheService::cacheUpdate($category);
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        CacheService::cacheUpdate($category, true);
    }
}
