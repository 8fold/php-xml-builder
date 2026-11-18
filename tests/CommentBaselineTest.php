<?php

declare(strict_types=1);

namespace Eightfold\XmlBuilder\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\XmlBuilder\Comment;

class CommentBaselineTest extends TestCase
{
    public function test_comment_can_be_initialized_statically(): void
    {
        parent::assertSame(
            "\n" . '<!-- content -->' . "\n",
            (string) Comment::create('content')
        );
    }
}
