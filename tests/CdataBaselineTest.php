<?php

use Eightfold\XMLBuilder\Cdata;

test('Cdata is Stringable', function() {
    expect(
        (string) Cdata::create('content')
    )->toBe(
        '<![CDATA[content]]>'
    );
});

test('Cdata can be static initialized', function() {
    expect(
        Cdata::create('content')->build()
    )->toBe(
        '<![CDATA[content]]>'
    );
});

test('CDATA exists', function() {
    $this->assertTrue(
        class_exists(Cdata::class)
    );

});
