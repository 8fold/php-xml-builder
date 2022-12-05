<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\XMLBuilder\Concatenate;

use Eightfold\XMLBuilder\Element;

class ConcatenateBaselineTest extends TestCase
{
    /**
     * @test
     */
    public function concatenate_expected_content(): void
    {
        $expected = '<p>Hello, World!</p> Testing additional string.';

        $result = (string) Concatenate::create(
            Element::p('Hello, World!'),
            ' Testing additional string.'
        );

        $this->assertSame(
            $expected,
            $result
        );
    }
}
