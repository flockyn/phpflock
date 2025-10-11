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

    /**
     * Determine if the given value is present.
     */
    public static function present(mixed $value): bool
    {
        return ! self::blank($value);
    }

    /**
     * Determine if the given value is truthy.
     */
    public static function truthy(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_null($value)) {
            return false;
        }

        if (is_numeric($value)) {
            return (float) $value !== 0.0;
        }

        if ($value instanceof Countable) {
            return count($value) > 0;
        }

        if (is_string($value) || $value instanceof Stringable) {
            $str = mb_strtolower(trim((string) $value));

            return $str !== '' && ! in_array($str, ['0', 'false', 'no', 'off', 'null', 'none'], true);
        }

        return ! empty($value);
    }
}
