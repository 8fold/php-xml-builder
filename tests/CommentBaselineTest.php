<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\XMLBuilder\Comment;

class CommentBaselineTest extends TestCase
{
    /**
     *@test
     */
    public function comment_is_stringable(): void
    {
        $this->assertEquals(
            (string) Comment::create('content'),
            "\n" . '<!-- content -->' . "\n"
        );
    }

    /**
     *@test
     */
    public function comment_can_be_initialized_statically(): void
    {
        $this->assertEquals(
            Comment::create('content')->build(),
            "\n" . '<!-- content -->' . "\n"
        );
    }

    /**
     *@test
     */
    public function comment_exists(): void
    {
        $this->assertTrue(class_exists(Comment::class));
    }
}
