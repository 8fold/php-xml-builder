<?php

declare(strict_types=1);

namespace Eightfold\XmlBuilder_\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use Eightfold\XmlBuilder_\Comment;

class CommentBaselineTest extends TestCase
{
    #[Test]
    public function comment_can_be_initialized_statically(): void
    {
        parent::assertSame(
            "\n" . '<!-- content -->' . "\n",
            (string) Comment::create('content')
        );
    }
}
