<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use Eightfold\XMLBuilder\Comment;

class CommentBaselineTest extends TestCase
{
    #[Test]
    public function comment_can_be_initialized_statically(): void
    {
        $this->assertSame(
            "\n" . '<!-- content -->' . "\n",
            (string) Comment::create('content')
        );
    }
}
