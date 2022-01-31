<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder\Implementations;

use Stringable;

trait Contentable
{
    /**
     * @var array<string|Stringable>
     */
    private array $content = [];

    /**
     * @param array<string|String> $content
     */
    public static function __callStatic(
        string $name,
        $content = []
    ): static {
        return static::create($name, ...$content);
    }

    public static function create(
        string $name,
        string|Stringable ...$content
    ): static {
        return new static($name, ...$content);
    }
}
