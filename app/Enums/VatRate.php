<?php

namespace App\Enums;

enum VatRate: string
{
    case ZERO_PERCENT = "0";
    case FIVE_PERCENT = "0.05";
    case TEN_PERCENT = "0.1";
    case TWENTY_PERCENT = "0.2";

    /**
     * Get VatRate cases as array of float values.
     *
     * @return array<float>
    */
    public static function values(): array
    {
        $values = [];
        foreach(array_column(self::cases(), "value") as $case) {
            $values[] = (float)$case;
        }
        return $values;
    }
}
