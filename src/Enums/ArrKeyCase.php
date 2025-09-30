<?php

declare(strict_types=1);

namespace Flockyn\PHPFlock\Enums;

use Flockyn\PHPFlock\Str;

enum ArrKeyCase
{
    case Camel;
    case Kebab;
    case Pascal;
    case Snake;

    /**
     * Apply the case transformation to the given string.
     */
    public function convert(string $value): string
    {
        return match ($this) {
            self::Camel => Str::camel($value),
            self::Kebab => Str::kebab($value),
            self::Pascal => Str::pascal($value),
            self::Snake => Str::snake($value),
        };
    }
}
