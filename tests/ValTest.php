<?php

declare(strict_types=1);

namespace Tests;

use Countable;
use Flockyn\PHPFlock\Val;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Stringable;

final class ValTest extends TestCase
{
    #[Test]
    public function it_blank(): void
    {
        $this->assertTrue(Val::blank(null));
        $this->assertTrue(Val::blank($this->toValCountable(0)));
        $this->assertTrue(Val::blank(''));
        $this->assertTrue(Val::blank(' '));
        $this->assertTrue(Val::blank($this->toValStringable('')));
        $this->assertTrue(Val::blank($this->toValStringable(' ')));
        $this->assertTrue(Val::blank([]));

        $this->assertFalse(Val::blank([1, 2, 3]));
        $this->assertFalse(Val::blank('foo'));
        $this->assertFalse(Val::blank($this->toValStringable('foo')));
        $this->assertFalse(Val::blank(0));
        $this->assertFalse(Val::blank(0.0));
        $this->assertFalse(Val::blank(true));
        $this->assertFalse(Val::blank(false));
        $this->assertFalse(Val::blank($this->toValCountable(1)));
    }

    #[Test]
    public function it_present(): void
    {
        $this->assertFalse(Val::present(null));
        $this->assertFalse(Val::present($this->toValCountable(0)));
        $this->assertFalse(Val::present(''));
        $this->assertFalse(Val::present(' '));
        $this->assertFalse(Val::present($this->toValStringable('')));
        $this->assertFalse(Val::present($this->toValStringable(' ')));
        $this->assertFalse(Val::present([]));

        $this->assertTrue(Val::present([1, 2, 3]));
        $this->assertTrue(Val::present('foo'));
        $this->assertTrue(Val::present($this->toValStringable('foo')));
        $this->assertTrue(Val::present(0));
        $this->assertTrue(Val::present(0.0));
        $this->assertTrue(Val::present(true));
        $this->assertTrue(Val::present(false));
        $this->assertTrue(Val::present($this->toValCountable(1)));
    }

    #[Test]
    public function it_truthy(): void
    {
        $this->assertFalse(Val::truthy(false));
        $this->assertFalse(Val::truthy(null));
        $this->assertFalse(Val::truthy(0));
        $this->assertFalse(Val::truthy(0.0));
        $this->assertFalse(Val::truthy($this->toValCountable(0)));
        $this->assertFalse(Val::truthy(''));
        $this->assertFalse(Val::truthy(' '));
        $this->assertFalse(Val::truthy($this->toValStringable('')));
        $this->assertFalse(Val::truthy($this->toValStringable(' ')));
        $this->assertFalse(Val::truthy([]));

        $this->assertTrue(Val::truthy(true));
        $this->assertTrue(Val::truthy([1, 2, 3]));
        $this->assertTrue(Val::truthy('foo'));
        $this->assertTrue(Val::truthy($this->toValStringable('foo')));
        $this->assertTrue(Val::truthy($this->toValCountable(1)));
    }

    private function toValCountable(int $value): Countable
    {
        return new class($value) implements Countable
        {
            public function __construct(private readonly int $count) {}

            public function count(): int
            {
                return $this->count;
            }
        };
    }

    private function toValStringable(string $value): Stringable
    {
        return new class($value) implements Stringable
        {
            public function __construct(private readonly string $string) {}

            public function __toString(): string
            {
                return $this->string;
            }
        };
    }
}
