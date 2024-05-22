<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum OrderStatus: string
{
    case PENDING = "Pending";
    case PROCESSED = "Processed";

    /**
     * Get OrderStatus color.
     *
     * @return string
     */
    public function color(): string
    {
        return match($this) {
            self::PENDING => "#f44",
            self::PROCESSED => "#0c0",
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

    /**
     * Get OrderStatus cases as array of values.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), "value");
    }
}
