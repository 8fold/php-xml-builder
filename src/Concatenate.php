<?php
declare(strict_types=1);

namespace Eightfold\XMLBuilder;

use Eightfold\XMLBuilder\Contracts\Buildable;
use Eightfold\XMLBuilder\Contracts\ContentWithoutElement;

use Stringable;

use Eightfold\XMLBuilder\Implementations\Buildable as BuildableImp;
use Eightfold\XMLBuilder\Implementations\ContentWithoutElement as ContentWithoutElementImp;

class Concatenate implements Buildable, ContentWithoutElement
{
    use BuildableImp;
    use ContentWithoutElementImp;

    public function __toString(): string
    {
        return implode('', $this->content);
    }
}
