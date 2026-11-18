<?php
declare(strict_types=1);

namespace Eightfold\XmlBuilder;

use Stringable;

use Eightfold\XmlBuilder\Contracts\ContentWithoutElement;

use Eightfold\XmlBuilder\Implementations\ContentWithoutElement as ContentWithoutElementImp;

class Concatenate implements Stringable, ContentWithoutElement
{
    use ContentWithoutElementImp;

    public function __toString(): string
    {
        return implode('', $this->content);
    }
}
