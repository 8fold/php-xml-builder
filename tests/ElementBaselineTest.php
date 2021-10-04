<?php

use Eightfold\XMLBuilder\Element;

test('Element is Stringable', function() {
    expect(
        (string) Element::create('root')->props('id 6', 'property hello')
            ->omitEndTag()
    )->toBe(
        '<root id="6" property="hello" />'
    );
});

test('Element can omit end tag', function() {
    expect(
        Element::create('root')->props('id 6', 'property hello')
            ->omitEndTag()->build()
    )->toBe(
        '<root id="6" property="hello" />'
    );
});

test('Element can have properties', function() {
    expect(
        Element::create('root')->props('id 6', 'property hello')->build()
    )->toBe(
        '<root id="6" property="hello"></root>'
    );
});

test('Element can accept content', function() {
    expect(
        Element::create('root',
            Element::create('child',
                Element::create('grandchild'),
                '<!CDATA[String]]>'
            )
        )->build()
    )->toBe(
        "<root><child><grandchild></grandchild><!CDATA[String]]></child></root>"
    );
});

test('Element can be static initialized', function() {
    expect(
        Element::create('tag')->build()
    )->toBe(
        '<tag></tag>'
    );
});

test('Element exists', function() {
    $this->assertTrue(
        class_exists(Element::class)
    );
});
