<?php

declare(strict_types=1);

namespace Eightfold\XmlBuilder\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\XmlBuilder\Cdata;

class CdataBaselineTest extends TestCase
{
    public function test_cdata_can_be_initialized_statically(): void
    {
        parent::assertSame(
            '<![CDATA[content]]>',
            (string) Cdata::create('content')
        );
    }
}
