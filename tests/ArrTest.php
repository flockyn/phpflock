<?php

declare(strict_types=1);

namespace Tests;

use Flockyn\PHPFlock\Arr;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ArrTest extends TestCase
{
    public static function dataProviderMapWithKeys(): array
    {
        return [
            'basic mapping' => [
                'data' => [
                    100 => ['id' => 1, 'name' => 'Alice', 'role' => 'Admin'],
                    200 => ['id' => 2, 'name' => 'Bob', 'role' => 'Guest'],
                    300 => ['id' => 3, 'name' => 'Charlie', 'role' => 'Admin'],
                ],
                'callback' => static fn (array $user): array => [$user['name'] => $user['id']],
                'expected' => [
                    'Alice' => 1,
                    'Bob' => 2,
                    'Charlie' => 3,
                ],
            ],
            'filtering items' => [
                'data' => [
                    ['status' => 'active', 'data' => 'A'],
                    ['status' => 'pending', 'data' => 'B'],
                    ['status' => 'active', 'data' => 'C'],
                ],
                'callback' => static fn (array $item, int $key): array => $item['status'] === 'active' ? [$item['data'] => $key] : [],
                'expected' => [
                    'A' => 0,
                    'C' => 2,
                ],
            ],
            'overwriting keys' => [
                'data' => [
                    'primary' => 1,
                    'secondary' => 2,
                    'final' => 3,
                ],
                'callback' => static fn (int $value): array => ['merged_value' => $value],
                'expected' => ['merged_value' => 3],
            ],
        ];
    }

    #[Test, DataProvider('dataProviderMapWithKeys')]
    public function it_map_with_keys(array $data, callable $callback, array $expected): void
    {
        $result = Arr::mapWithKeys($data, $callback);

        $this->assertSame($expected, $result);
    }
}
