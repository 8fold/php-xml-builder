<?php

namespace Eightfold\XmlBuilder_\Contracts;

use Stringable;

interface ContentWithoutElement
{
    public static function create(string|Stringable ...$content): self;
}
