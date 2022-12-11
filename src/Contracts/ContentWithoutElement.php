<?php

namespace Eightfold\XMLBuilder\Contracts;

use Stringable;

interface ContentWithoutElement
{
    public static function create(string|Stringable ...$content): self;
}
