<?php

namespace Eightfold\XMLBuilder\Contracts;

use Stringable;

interface Elemental
{
    /**
     * @param array<string|Stringable> $content
     */
    public static function __callStatic(
        string $name,
        $content = []
    ): static;

    public static function create(
        string $name,
        string|Stringable ...$content
    ): static;
}
