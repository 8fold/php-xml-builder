<?php

declare(strict_types=1);

namespace Eightfold\XmlBuilder_\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use Eightfold\XmlBuilder_\Cdata;

class CdataBaselineTest extends TestCase
{
    #[Test]
    public function cdata_can_be_initialized_statically(): void
    {
        parent::assertSame(
            '<![CDATA[content]]>',
            (string) Cdata::create('content')
        );
    }
}
