<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum OrderStatus: string
{
    case PROCESSED = "Processed";
    case PENDING = "Pending";

    /**
     * Get OrderStatus color.
     *
     * @return string
     */
    public function color(): string
    {
        return match($this) {
            self::PENDING => "#f44",
            self::PROCESSED => "#4f4",
        };
    }

    /**
     * Get OrderStatus slug.
     *
     * @return string
     */
    public function slug(): string
    {
        return Str::slug($this->value);
    }
}
