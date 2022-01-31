<?php

namespace Eightfold\XMLBuilder\Contracts;

use Stringable;

interface Buildable extends Stringable
{
    public function build(): string;
}
