<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder;

use Stringable;

class Cdata implements Stringable
{
    public static function create(string|Stringable $content): static
    {
        return new static($content);
    }

    final private function __construct(private string|Stringable $content)
    {
    }

    public function __toString(): string
    {
        return '<![CDATA[' . $this->content . ']]>';
    }
}
