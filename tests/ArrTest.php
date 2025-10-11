<?php

declare(strict_types=1);

namespace Tests;

use Flockyn\PHPFlock\Arr;
use Flockyn\PHPFlock\Enums\ArrKeyCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ArrTest extends TestCase
{
    public static function dataProviderKeyCase(): array
    {
        static $nested = [
            'is_active' => true,
            'login-attempts' => 3,
            'preferences' => ['LanguageCode' => 'en', 'theme_color' => 'dark', 'font-size' => 'medium'],
        ];

        $keyCaseCallable = [
            'callable_first_name' => 'John',
            'callable_email-address' => 'john@example.com',
            'callable_userid' => 100,
            'callable_urlpath-foravatar' => 'https://example.com/avatar.jpg',
            'callable_logs' => [0 => 'Log entry 1', 1 => 'Log entry 2'],
            'callable_account_settings' => [
                'callable_is_active' => true,
                'callable_login-attempts' => 3,
                'callable_preferences' => ['callable_languagecode' => 'en', 'callable_theme_color' => 'dark', 'callable_font-size' => 'medium'],
            ],
        ];

        return [
            'camel case depth inf' => [
                'expected' => self::keyCaseCamelExpectedConversion(),
                'case' => ArrKeyCase::Camel,
                'depth' => INF,
            ],
            'camel case depth 1' => [
                'expected' => self::keyCaseCamelExpectedConversion($nested),
                'case' => ArrKeyCase::Camel,
                'depth' => 1,
            ],
            'kebab case depth inf' => [
                'expected' => self::keyCaseKebabExpectedConversion(),
                'case' => ArrKeyCase::Kebab,
                'depth' => INF,
            ],
            'kebab case depth 1' => [
                'expected' => self::keyCaseKebabExpectedConversion($nested),
                'case' => ArrKeyCase::Kebab,
                'depth' => 1,
            ],
            'pascal case depth inf' => [
                'expected' => self::keyCasePascalExpectedConversion(),
                'case' => ArrKeyCase::Pascal,
                'depth' => INF,
            ],
            'pascal case depth 1' => [
                'expected' => self::keyCasePascalExpectedConversion($nested),
                'case' => ArrKeyCase::Pascal,
                'depth' => 1,
            ],
            'snake case depth inf' => [
                'expected' => self::keyCaseSnakeExpectedConversion(),
                'case' => ArrKeyCase::Snake,
                'depth' => INF,
            ],
            'snake case depth 1' => [
                'expected' => self::keyCaseSnakeExpectedConversion($nested),
                'case' => ArrKeyCase::Snake,
                'depth' => 1,
            ],
            'callable case depth inf' => [
                'expected' => $keyCaseCallable,
                'case' => fn (string $key): string => 'callable_'.mb_strtolower($key),
                'depth' => INF,
            ],
            'callable case depth 1' => [
                'expected' => self::keyCaseSnakeExpectedConversion($nested),
                'case' => fn (string $key): string => ArrKeyCase::Snake->convert($key),
                'depth' => 1,
            ],
        ];
    }

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

    #[Test]
    public function it_is_assoc(): void
    {
        $this->assertTrue(Arr::isAssoc(['a' => 1, 'b' => 2, 'c' => 3]));
        $this->assertFalse(Arr::isAssoc([1, 2, 3]));
    }

    #[Test, DataProvider('dataProviderKeyCase')]
    public function it_key_case_conversion(array $expected, ArrKeyCase|callable $case, float|int $depth): void
    {
        $data = Arr::keyCase($this->dataKeyCaseConversion(), $case, $depth);

        $this->assertSame($expected, $data);
    }

    #[Test, DataProvider('dataProviderMapWithKeys')]
    public function it_map_with_keys(array $data, callable $callback, array $expected): void
    {
        $result = Arr::mapWithKeys($data, $callback);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_to_camel_keys_conversion(): void
    {
        $data = Arr::toCamelKeys($this->dataKeyCaseConversion());

        $this->assertSame(self::keyCaseCamelExpectedConversion(), $data);
    }

    #[Test]
    public function it_to_kebab_keys_conversion(): void
    {
        $data = Arr::toKebabKeys($this->dataKeyCaseConversion());

        $this->assertSame(self::keyCaseKebabExpectedConversion(), $data);
    }

    #[Test]
    public function it_to_pascal_keys_conversion(): void
    {
        $data = Arr::toPascalKeys($this->dataKeyCaseConversion());

        $this->assertSame(self::keyCasePascalExpectedConversion(), $data);
    }

    #[Test]
    public function it_to_snake_keys_conversion(): void
    {
        $data = Arr::toSnakeKeys($this->dataKeyCaseConversion());

        $this->assertSame(self::keyCaseSnakeExpectedConversion(), $data);
    }

    private static function keyCaseCamelExpectedConversion(?array $nested = null): array
    {
        $nested ??= [
            'isActive' => true,
            'loginAttempts' => 3,
            'preferences' => ['languageCode' => 'en', 'themeColor' => 'dark', 'fontSize' => 'medium'],
        ];

        return [
            'firstName' => 'John',
            'emailAddress' => 'john@example.com',
            'userId' => 100,
            'urlPathForAvatar' => 'https://example.com/avatar.jpg',
            'logs' => [0 => 'Log entry 1', 1 => 'Log entry 2'],
            'accountSettings' => $nested,
        ];
    }

    private static function keyCaseKebabExpectedConversion(?array $nested = null): array
    {
        $nested ??= [
            'is-active' => true,
            'login-attempts' => 3,
            'preferences' => ['language-code' => 'en', 'theme-color' => 'dark', 'font-size' => 'medium'],
        ];

        return [
            'first-name' => 'John',
            'email-address' => 'john@example.com',
            'user-id' => 100,
            'url-path-for-avatar' => 'https://example.com/avatar.jpg',
            'logs' => [0 => 'Log entry 1', 1 => 'Log entry 2'],
            'account-settings' => $nested,
        ];
    }

    private static function keyCasePascalExpectedConversion(?array $nested = null): array
    {
        $nested ??= [
            'IsActive' => true,
            'LoginAttempts' => 3,
            'Preferences' => ['LanguageCode' => 'en', 'ThemeColor' => 'dark', 'FontSize' => 'medium'],
        ];

        return [
            'FirstName' => 'John',
            'EmailAddress' => 'john@example.com',
            'UserId' => 100,
            'UrlPathForAvatar' => 'https://example.com/avatar.jpg',
            'Logs' => [0 => 'Log entry 1', 1 => 'Log entry 2'],
            'AccountSettings' => $nested,
        ];
    }

    private static function keyCaseSnakeExpectedConversion(?array $nested = null): array
    {
        $nested ??= [
            'is_active' => true,
            'login_attempts' => 3,
            'preferences' => ['language_code' => 'en', 'theme_color' => 'dark', 'font_size' => 'medium'],
        ];

        return [
            'first_name' => 'John',
            'email_address' => 'john@example.com',
            'user_id' => 100,
            'url_path_for_avatar' => 'https://example.com/avatar.jpg',
            'logs' => [0 => 'Log entry 1', 1 => 'Log entry 2'],
            'account_settings' => $nested,
        ];
    }

    private function dataKeyCaseConversion(): array
    {
        return [
            'first_name' => 'John',
            'email-address' => 'john@example.com',
            'UserID' => 100,
            'URLPath-forAvatar' => 'https://example.com/avatar.jpg',
            'logs' => [0 => 'Log entry 1', 1 => 'Log entry 2'],
            'account_settings' => [
                'is_active' => true,
                'login-attempts' => 3,
                'preferences' => ['LanguageCode' => 'en', 'theme_color' => 'dark', 'font-size' => 'medium'],
            ],
        ];
    }
}
