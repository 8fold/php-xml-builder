<?php

use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;
use Eightfold\XMLBuilder\Cdata;

test('Document is Stringable', function() {
    expect(
        (string) Document::create('root')->props('id 6', 'property hello')
    )->toBe(
        '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>'."\n".'<root id="6" property="hello"></root>'
    );
});

test('Document can have properties', function() {
    expect(
        Document::create('root')->props('id 6', 'property hello')->build()
    )->toBe(
        '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>'."\n".'<root id="6" property="hello"></root>'
    );
});

test('Document can use shorthand', function() {
    expect(
        Document::root(
            Element::child(
                Element::grandchild(),
                Cdata::create('String')
            )
        )->build()
    )->toBe(
        '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>'."\n".'<root><child><grandchild></grandchild><![CDATA[String]]></child></root>'
    );
});

test('Document can accept content', function() {
    expect(
        Document::create('root',
            Element::create('child',
                Element::create('grandchild'),
                Cdata::create('String')
            )
        )->build()
    )->toBe(
        '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>'."\n".'<root><child><grandchild></grandchild><![CDATA[String]]></child></root>'
    );
});

test('Document can be static initialized', function() {
    expect(
        Document::create('tag')->build()
    )->toBe(
        '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>'."\n".'<tag></tag>'
    );
});

test('Document exists', function() {
    $this->assertTrue(
        class_exists(Document::class)
    );
});
