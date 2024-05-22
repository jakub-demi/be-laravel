<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CacheService
{
    public const CACHING_MINUTES = 60;

    /**
     * Re-cache specific model's database entry based on model's id while uncaching model's all entries' collection.
     *
     * @param Model $model
     * @param bool|null $deletion
     * @param float|int $minutes
     * @return void
     */
    public static function cacheUpdate(Model $model, ?bool $deletion = false, float|int $minutes = self::CACHING_MINUTES): void
    {
        $class = $model::class;

        cache()->forget("{$class}.all");

        if (!$model->id) return;

        $key = "{$class}.specific.{$model->id}";

        if ($deletion) {
            cache()->forget($key);
        } else {
            cache()->put($key, $model, now()->addMinutes($minutes));
        }
    }

    /**
     * Cache Collection **$data** paired with **$cacheKey**.
     *
     * @param string $cacheKey
     * @param Model|Collection|Builder|array|null $data
     * @param float|int $minutes
     * @return void
     */
    public static function cacheCollection(string $cacheKey, Model|Collection|Builder|array|null $data, float|int $minutes = self::CACHING_MINUTES): void
    {
        if (!$data) return;

        cache()->remember($cacheKey, now()->addMinutes($minutes), function() use ($data) {
            return $data;
        });
    }
}
