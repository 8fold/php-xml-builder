<?php

use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;
use Eightfold\XMLBuilder\Comment;
use Eightfold\XMLBuilder\Cdata;

test('Document is speedy', function() {
    $start = hrtime(true);

    $items = [];
    for ($i = 0; $i < 10; $i++) {
        if ($i > 2 and $i < 8) {
            $items[] = Comment::create($i);

        }

        if ($i === 4) {
            $items[] = Element::item(
                Cdata::create('CDATA ' . $i)
            );

        } else {
            $items[] = Element::item("Hello, {$i}!");

        }

    }

    $result = (string) Document::root(...$items);

    $end = hrtime(true);

    expect($result)->toBe(<<<doc
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
        doc
    );

    $elapsed = $end - $start;
    $ms      = $elapsed/1e+6;

    expect($ms)->toBeLessThan(0.2);
});

test('Document is small', function() {
    $start = memory_get_usage();;

    $items = [];
    for ($i = 0; $i < 10; $i++) {
        if ($i > 2 and $i < 8) {
            $items[] = Comment::create($i);

        }

        if ($i === 4) {
            $items[] = Element::item(
                Cdata::create('CDATA ' . $i)
            );

        } else {
            $items[] = Element::item("Hello, {$i}!");

        }

    }

    $result = (string) Document::root(...$items);

    $end = memory_get_usage();

    expect($result)->toBe(<<<doc
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
        doc
    );

    $used = $end - $start;
    $kb   = round($used/1024.2);

    expect($kb)->toBeLessThan(10);
});
