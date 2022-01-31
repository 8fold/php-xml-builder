<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\XMLBuilder\Implementations\Buildable as BuildableImp;

class Comment implements Buildable
{
    use BuildableImp;

    public static function create(string $content): static
    {
        return new static($content);
    }

    final private function __construct(private string $content)
    {
    }

    public function __toString(): string
    {
        return "\n" . '<!-- ' . $this->content . ' -->' . "\n";
    }
}
