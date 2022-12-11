<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder\Implementations;

use Stringable;

trait ContentWithoutElement
{
    /**
     * @var array<string|Stringable>
     */
    private array $content = [];

    public static function create(string|Stringable ...$content): static
    {
        return new static(...$content);
    }

    final private function __construct(string|Stringable ...$content)
    {
        $this->content = $content;
    }
}
