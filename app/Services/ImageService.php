<?php

namespace App\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image as ImageFacade;
use App\Models\Image;

class ImageService
{
    /**
     * Save uploaded image, create all versions of image and create or update a model for image
     */
    public function uploadImage(Request $request, Model $model, string $input, string $directory, string $type = null): void
    {
        if (!$request->hasFile($input)) {
            return;
        }

        $data = $this->buildModelData($request, $model, $input, $directory, $type);

        $this->createTransformedImages($directory, $data);

        $image_model = $this->getExistingImageModel($model, $type);

        !$image_model ? $model->images()->create($data) : $image_model->update($data);
    }

    /**
     * Get existing Image model or null
     */
    public function getExistingImageModel(Authenticatable|Model $model, ?string $type): ?Image
    {
        return !isset($type) ? null : $model->images->where('type', $type)->first() ?? null;
    }

    /**
     * Create all transformed versions of image (image types)
     */
    public function createTransformedImages(string $directory, array &$data): void
    {
        $directory_path = public_path($data['path']);

        foreach ($this->settings($directory) as $type => $settings) {
            $data[$type] = $this->createTransformedImage($type, $settings, $data['basename'], $directory_path, $data['extension']);
        }

        $data['basename'] = $data['basename'] . '.' . $data['extension'];
    }

    /**
     * Create transformed version of image (image type)
     */
    public function createTransformedImage(string $type, array $settings, string $imageBasename, string $directory_path, string $extension): string
    {
        $fullPath = $directory_path.$imageBasename . '.' . $extension;

        $image = ImageFacade::read($fullPath);

        $image = $this->transform($image, $settings);

        $newExtension = "webp";

        $image->toWebp()->save("$directory_path{$type}_$imageBasename.$newExtension");

        return "{$type}_$imageBasename.$newExtension";
    }

    /**
     * Build model data for Image model
     */
    public function buildModelData(Request $request, Authenticatable|Model $model, string $input, string $dir, ?string $type): array
    {
        $path = "$dir/{$model->id}";
        $file = $request->file($input);
        $extension = $file->extension();

        $basename = pathinfo(Storage::disk('public_data')->put($path, $file), PATHINFO_FILENAME);

        $path = "data/" . $path . "/";

        return compact('basename', 'path', 'type', 'extension');
    }

    /**
     * Build settings for image namespace from config/image.php
     */
    private function settings(string $key): array
    {
        $cfg = config('image');
        $default = $cfg['_default'];

        if (!array_key_exists($key, $cfg)) {
            return $default;
        }

        foreach ($settings = $cfg[$key] as $type => $type_settings) {
            $type_settings === true
                ? $this->setDefaultImageType($settings, $type, $default)
                : $this->setDefaultImageAttributes($settings, $type, $default);
        }

        return $settings;
    }

    /**
     * Set default image settings (if set to true) for specific image type
     */
    private function setDefaultImageType(array &$settings, string $type, array $default): void
    {
        $settings[$type] = $default[$type];
    }

    /**
     * Set default image settings attributes (if missing) for specific image type
     */
    private function setDefaultImageAttributes(array &$settings, string $type, array $default): void
    {
        $settings[$type]['width'] ??= $default[$type]['width'];
        $settings[$type]['height'] ??= $default[$type]['height'];
        $settings[$type]['transformation'] ??= false;
    }

    /**
     * Transform image according to settings
     */
    private function transform(ImageInterface $image, array $settings): ImageInterface
    {
        return match ($settings['transformation']) {
            'contain' => $image->contain($settings['width'], $settings['height']),
            'cover' => $image->cover($settings['width'], $settings['height']),
            'coverDown' => $image->coverDown($settings['width'], $settings['height']),
            'crop' => $image->crop($settings['width'], $settings['height'], position: 'center'),
            'pad' => $image->pad($settings['width'], $settings['height']),
            'resize' => $image->resize($settings['width'], $settings['height']),
            'resizeDown' => $image->resizeDown($settings['width'], $settings['height']),
            'scale' => $image->scale($settings['width'], $settings['height']),
            'scaleDown' => $image->scaleDown($settings['width'], $settings['height']),
        };
    }
}
