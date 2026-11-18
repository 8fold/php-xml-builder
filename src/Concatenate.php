<?php
declare(strict_types=1);

namespace Eightfold\XmlBuilder_;

use Stringable;

use Eightfold\XmlBuilder_\Contracts\ContentWithoutElement;

use Eightfold\XmlBuilder_\Implementations\ContentWithoutElement as ContentWithoutElementImp;

class Concatenate implements Stringable, ContentWithoutElement
{
    use ContentWithoutElementImp;

    public function __toString(): string
    {
        return implode('', $this->content);
    }
}
