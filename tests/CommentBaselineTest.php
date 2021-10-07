<?php

use Eightfold\XMLBuilder\Comment;

test('Comment is Stringable', function() {
    expect(
        (string) Comment::create('content')
    )->toBe(
        "\n" . '<!-- content -->' . "\n"
    );
});

test('Cdata can be static initialized', function() {
    expect(
        Comment::create('content')->build()
    )->toBe(
        "\n" . '<!-- content -->' . "\n"
    );
});

test('Comment exists', function() {
    $this->assertTrue(
        class_exists(Comment::class)
    );

});
