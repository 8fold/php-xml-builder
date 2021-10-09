<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder;

use Eightfold\XMLBuilder\Contracts\Buildable;

// use \Stringable;

// TODO: PHP8 - specify implementing Stringable
class Comment implements Buildable // implements Stringable
{
    private string $content = '';

    public static function create(string $content): Comment
    {
        return new static($content);
    }

    final public function __construct(string $content)
    {
        $this->content     = $content;
    }

    private function content(): string
    {
        return $this->content;
    }

    public function build(): string
    {
        return "\n" . '<!-- ' . $this->content() . ' -->' . "\n";
    }

    public function __toString(): string
    {
        return $this->build();
    }
}
