<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder\Implementations;

trait Buildable
{
    public function build(): string
    {
        return strval($this);
    }
}
