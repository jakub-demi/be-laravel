<?php

namespace App\Enums;

use ReflectionClass;

enum VatRate
{
    const ZERO_PERCENT = 0;
    const FIVE_PERCENT = 0.05;
    const TEN_PERCENT = 0.1;
    const TWENTY_PERCENT = 0.2;

//    public static function values(): array
//    {
//        //return (new ReflectionClass(self::class))->getConstants();
//        return self::cases();
//    }
}
