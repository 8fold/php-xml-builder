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
    public function cdata_is_stringable(): void
    {
        $this->assertEquals(
            (string) Cdata::create('content'),
            '<![CDATA[content]]>'
        );
    }

    /**
     *@test
     */
    public function cdata_can_be_initialized_statically(): void
    {
        $this->assertEquals(
            Cdata::create('content')->build(),
            '<![CDATA[content]]>'
        );
    }

    /**
     *@test
     */
    public function cdata_exists(): void
    {
        $this->assertTrue(class_exists(Cdata::class));
    }
}
