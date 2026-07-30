<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CccdValidationTest extends TestCase
{
    public function test_cccd_must_be_12_digits(): void
    {
        $this->assertMatchesRegularExpression('/^\d{12}$/', '123456789012');
        $this->assertDoesNotMatchRegularExpression('/^\d{12}$/', '12345678901');
        $this->assertDoesNotMatchRegularExpression('/^\d{12}$/', '12345678901a');
    }
}
