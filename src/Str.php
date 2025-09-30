<?php

declare(strict_types=1);

namespace Flockyn\PHPFlock;

final class Str
{
    /**
     * Cache for normalized words.
     *
     * @var array<string, list<string>>
     */
    private static array $normalizedWords = [];

    /**
     * Convert a string to a pascal case.
     */
    public static function pascal(string $value): string
    {
        return implode('', array_map('ucfirst', self::normalizeToWords($value)));
    }

    /**
     * Convert a string to a snake case.
     */
    public static function snake(string $value, string $separator = '_'): string
    {
        return implode($separator, self::normalizeToWords($value));
    }

    /**
     * Normalize a string to words.
     *
     * @return list<string>
     */
    private static function normalizeToWords(string $value): array
    {
        $key = $value;

        if (isset(self::$normalizedWords[$key])) {
            return self::$normalizedWords[$key];
        }

        // 1. Insert space before any capital letter preceded by a lowercase letter or digit.
        $value = preg_replace('/(?<=[a-z0-9])(?=[A-Z])/', ' ', $value);

        // 2. Insert space before the last capital letter in an acronym if it's followed by a lowercase letter.
        $value = preg_replace('/([A-Z])([A-Z][a-z])/', '$1 $2', (string) $value);

        // 3. Convert all remaining separators to spaces.
        $value = str_replace(['-', '_'], ' ', (string) $value);

        // 4. Convert to lowercase with UTF-8 encoding.
        $value = mb_strtolower($value, 'UTF-8');

        // 4. Split by space and remove empty values.
        /** @var list<string> $normalized */
        $normalized = array_filter(explode(' ', (string) $value));

        return self::$normalizedWords[$key] = $normalized;
    }
}
