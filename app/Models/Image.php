<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'basename',
        'image',
        'thumb',
        'path',
        'type',
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo('imageable');
    }

    public function get_type($type = 'basename'): ?string
    {
        return $this->path && $this->$type ? $this->path . $this->$type : null;
    }
}
