<?php

declare(strict_types=1);

namespace Flockyn\PHPFlock;

use Countable;
use Stringable;

final class Val
{
    /**
     * Determine if the given value is blank.
     */
    public static function blank(mixed $value): bool
    {
        if (is_null($value)) {
            return true;
        }

        if ($value instanceof Countable) {
            return count($value) === 0;
        }

        if (is_string($value) || $value instanceof Stringable) {
            return trim((string) $value) === '';
        }

        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        return empty($value);
    }
}
