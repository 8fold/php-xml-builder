<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;
use Eightfold\XMLBuilder\Cdata;
use Eightfold\XMLBuilder\Comment;

class PerformanceTest extends TestCase
{
    /**
     *@test
     */
    public function document_is_speedy(): void
    {
        $start = hrtime(true);

        $items = [];
        for ($i = 0; $i < 10; $i++) {
            $j = strval($i);
            if ($i > 2 and $i < 8) {
                $items[] = Comment::create($j);
            }

            if ($i === 4) {
                $items[] = Element::item(
                    Cdata::create('CDATA ' . $j)
                );

            } else {
                $items[] = Element::item("Hello, {$j}!");

            }
        }

        $result = (string) Document::root(...$items);

        $end = hrtime(true);

        $expected = <<<doc
            <?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>
            <root><item>Hello, 0!</item><item>Hello, 1!</item><item>Hello, 2!</item>
            <!-- 3 -->
            <item>Hello, 3!</item>
            <!-- 4 -->
            <item><![CDATA[CDATA 4]]></item>
            <!-- 5 -->
            <item>Hello, 5!</item>
            <!-- 6 -->
            <item>Hello, 6!</item>
            <!-- 7 -->
            <item>Hello, 7!</item><item>Hello, 8!</item><item>Hello, 9!</item></root>
            doc;

        $this->assertEquals($expected, $result);

        $elapsed = $end - $start;
        $ms      = $elapsed/1e+6;

        $this->assertLessThan(0.2, $ms);
    }

    /**
     *@test
     */
    public function document_is_small(): void
    {
        $start = memory_get_usage();

        $items = [];
        for ($i = 0; $i < 10; $i++) {
            $j = strval($i);
            if ($i > 2 and $i < 8) {
                $items[] = Comment::create($j);
            }

            if ($i === 4) {
                $items[] = Element::item(
                    Cdata::create('CDATA ' . $j)
                );

            } else {
                $items[] = Element::item("Hello, {$j}!");

            }
        }

        $result = (string) Document::root(...$items);

        $end = memory_get_usage();

        $expected = <<<doc
            <?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>
            <root><item>Hello, 0!</item><item>Hello, 1!</item><item>Hello, 2!</item>
            <!-- 3 -->
            <item>Hello, 3!</item>
            <!-- 4 -->
            <item><![CDATA[CDATA 4]]></item>
            <!-- 5 -->
            <item>Hello, 5!</item>
            <!-- 6 -->
            <item>Hello, 6!</item>
            <!-- 7 -->
            <item>Hello, 7!</item><item>Hello, 8!</item><item>Hello, 9!</item></root>
            doc;

        $this->assertEquals($expected, $result);

        $used = $end - $start;
        $kb   = round($used/1024.2);

        $this->assertLessThan(8, $kb);
    }
}
