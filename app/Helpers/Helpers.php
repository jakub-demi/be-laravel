<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Helpers
{
    /**
     * Generates unique slug for specific **$model** based on provided **$str**. Further **$column** can be also specified.
     *
     * @param Model $model
     * @param string $str
     * @param ?string $column
     * @return string
     */
    public static function generateUniqueSlug(Model $model, string $str, ?string $column = "slug"): string
    {
        $slug = Str::slug($str);
        $suffix = "";

        $slugExists = $model::where($column, $slug)->exists();

        if ($slugExists) {
            $i = 1;
            while($model::where($column, "{$slug}-{$i}")->exists()) {
                $i++;
            }
            $suffix = "-{$i}";
        }

        return "{$slug}{$suffix}";
    }
}
