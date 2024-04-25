<?php

namespace App\Enums;

enum VatRate: string
{
    case ZERO_PERCENT = "0";
    case FIVE_PERCENT = "0.05";
    case TEN_PERCENT = "0.1";
    case TWENTY_PERCENT = "0.2";

    /**
     * Get VatRate cases as array of values.
    */
    public static function values(): array
    {
        return array_column(self::cases(), "value");
    }
}
