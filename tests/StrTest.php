<?php

declare(strict_types=1);

namespace Tests;

use Flockyn\PHPFlock\Str;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class StrTest extends TestCase
{
    #[Test]
    public function it_pascal_conversion(): void
    {
        $this->assertSame('FirstName', Str::pascal('first_name'));
        $this->assertSame('ApiKeyValue', Str::pascal('api-key-value'));
        $this->assertSame('DatabaseConnection', Str::pascal('DatabaseConnection'));
        $this->assertSame('UserIdAndUrlPath', Str::pascal('userIDAndURLPath'));
        $this->assertSame('MixedCaseInputValue', Str::pascal('mixed-case_input Value'));
        $this->assertSame('FirstName', Str::pascal('firstName'));
    }

    #[Test]
    public function it_snake_conversion(): void
    {
        $this->assertSame('first_name', Str::snake('first_name'));
        $this->assertSame('api_key_value', Str::snake('api-key-value'));
        $this->assertSame('database_connection', Str::snake('DatabaseConnection'));
        $this->assertSame('user_id_and_url_path', Str::snake('userIDAndURLPath'));
        $this->assertSame('mixed_case_input_value', Str::snake('mixed-case_input Value'));
        $this->assertSame('first_name', Str::snake('firstName'));
    }
}
