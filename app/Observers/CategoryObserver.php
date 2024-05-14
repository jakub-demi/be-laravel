<?php

namespace App\Observers;

use App\Helpers\Helpers;
use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "creating" event.
     */
    public function creating(Category $category): void
    {
        $category->slug = Helpers::generateUniqueSlug($category, $category->name);
    }
}
