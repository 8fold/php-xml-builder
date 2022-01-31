<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder;

use Stringable;

use Eightfold\XMLBuilder\Contracts\Buildable;
use Eightfold\XMLBuilder\Contracts\Contentable;

use Eightfold\XMLBuilder\Implementations\Properties as PropertiesImp;
use Eightfold\XMLBuilder\Implementations\Buildable as BuildableImp;
use Eightfold\XMLBuilder\Implementations\Contentable as ContentableImp;

class Document implements Buildable, Contentable
{
    use PropertiesImp;
    use BuildableImp;
    use ContentableImp;

    final private function __construct(
        private string $name,
        string|Stringable ...$content
    ) {
        $this->content  = $content;
    }

    public function __toString(): string
    {
        $doctype =
            '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>'
            . "\n";
        return $doctype . $this->opening() . implode('', $this->content)
            . $this->closing();
    }

    private function opening(): string
    {
        return '<' . $this->name . $this->propertiesString() . '>';
    }

    private function closing(): string
    {
        return '</' . $this->name . '>';
    }
}
