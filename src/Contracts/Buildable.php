<?php

namespace Eightfold\XMLBuilder\Contracts;

interface Buildable
{
    public function build(): string;

    public function __toString(): string;
}
