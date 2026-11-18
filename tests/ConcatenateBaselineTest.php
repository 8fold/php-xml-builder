<?php

declare(strict_types=1);

namespace Eightfold\XmlBuilder_\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use Eightfold\XmlBuilder_\Concatenate;

use Eightfold\XmlBuilder_\Element;

class ConcatenateBaselineTest extends TestCase
{
    #[Test]
    public function concatenate_expected_content(): void
    {
        $expected = '<p>Hello, World!</p> Testing additional string.';

        $result = (string) Concatenate::create(
            Element::p('Hello, World!'),
            ' Testing additional string.'
        );

        parent::assertSame(
            $expected,
            $result
        );
    }
}
