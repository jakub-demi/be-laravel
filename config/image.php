<?php

use Intervention\Image\Drivers\Gd\Driver;

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports “GD Library” and “Imagick” to process images
    | internally. Depending on your PHP setup, you can choose one of them.
    |
    | Included options:
    |   - \Intervention\Image\Drivers\Gd\Driver::class
    |   - \Intervention\Image\Drivers\Imagick\Driver::class
    |
    */

    'driver' => Driver::class,

    //--------------------------[Settings For Images]--------------------------

    // Default Settings For Images
    '_default' => [
        'image' => [
            'width' => 1200,
            'height' => 800,
            'transformation' => 'scale'
        ],
        'thumb' => [
            'width' => 400,
            'height' => 400,
            'transformation' => 'crop'
        ],
    ],

    // Profile Avatars
    'profile-avatars' => [
        'image' => [
            'width' => 360,
            'height' => 360,
            'transformation' => 'resize'
        ],
    ]
];
