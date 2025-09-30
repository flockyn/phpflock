<?php

declare(strict_types=1);

namespace Tests;

use Flockyn\PHPFlock\Example;
use PHPUnit\Framework\TestCase;

final class ExampleTest extends TestCase
{
    public function test_example(): void
    {
        $this->assertSame('Hello World', (new Example)->run());
    }
}
