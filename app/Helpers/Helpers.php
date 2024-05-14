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

        $slugExists = $model::where($column, "LIKE", "{$slug}%")->orderBy($column, "desc")->first()?->slug;

        if ($slugExists) {
            /** @var string $slugExists */
            $existingSlugParts = explode("-", $slugExists);

            $suffix = (!empty($existingSlugParts) && is_numeric(last($existingSlugParts)) && (int)last($existingSlugParts) == last($existingSlugParts))
                ? "-" . ((int)last($existingSlugParts) + 1)
                : "-1";
        }

        return "{$slug}{$suffix}";
    }
}
