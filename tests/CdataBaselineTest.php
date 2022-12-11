<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\XMLBuilder\Cdata;

class CdataBaselineTest extends TestCase
{
    /**
     *@test
     */
    public function cdata_can_be_initialized_statically(): void
    {
        $this->assertSame(
            '<![CDATA[content]]>',
            (string) Cdata::create('content')
        );
    }
}
