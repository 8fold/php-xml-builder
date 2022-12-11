<?php
declare(strict_types=1);

namespace Eightfold\XMLBuilder;

use Stringable;

use Eightfold\XMLBuilder\Contracts\ContentWithoutElement;

use Eightfold\XMLBuilder\Implementations\ContentWithoutElement as ContentWithoutElementImp;

class Concatenate implements Stringable, ContentWithoutElement
{
    use ContentWithoutElementImp;

    public function __toString(): string
    {
        return implode('', $this->content);
    }
}
