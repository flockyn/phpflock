<?php

declare(strict_types=1);

namespace Flockyn\PHPFlock;

use Flockyn\PHPFlock\Enums\ArrKeyCase;

final class Arr
{
    /**
     * Change the case of array keys to the specified case.
     *
     * @param  array<array-key, mixed>  $array
     * @param  ArrKeyCase|callable(string): string  $case
     * @return array<array-key, mixed>
     */
    public static function keyCase(array $array, ArrKeyCase|callable $case, float|int $depth = INF): array
    {
        return self::mapWithKeys($array, static function ($value, int|string $key) use ($case, $depth): array {
            if (is_array($value) && $depth > 1) {
                $value = self::keyCase($value, $case, $depth - 1);
            }

            $newKey = $key;

            if (is_string($newKey)) {
                $newKey = is_callable($case) ? $case($key) : $case->convert($key);
            }

            return [$newKey => $value];
        });
    }

    /**
     * Map the given array using the given callback.
     *
     * @template TKey of array-key
     * @template TValue
     * @template TMapWithKeysKey of array-key
     * @template TMapWithKeysValue
     *
     * @param  array<TKey, TValue>  $array
     * @param  callable(TValue, TKey): array<TMapWithKeysKey, TMapWithKeysValue>  $callback
     * @return array<TMapWithKeysKey, TMapWithKeysValue>
     */
    public static function mapWithKeys(array $array, callable $callback): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $assoc = $callback($value, $key);

            foreach ($assoc as $mapKey => $mapValue) {
                $result[$mapKey] = $mapValue;
            }
        }

        return $result;
    }

    /**
     * Change the case of array keys to the camel case.
     *
     * @param  array<array-key, mixed>  $array
     * @return array<array-key, mixed>
     */
    public static function toCamelKeys(array $array, float|int $depth = INF): array
    {
        return self::keyCase($array, ArrKeyCase::Camel, $depth);
    }
}
