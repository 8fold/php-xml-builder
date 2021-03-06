<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder;

use Stringable;

use Eightfold\XMLBuilder\Contracts\Buildable;
use Eightfold\XMLBuilder\Contracts\Contentable;

use Eightfold\XMLBuilder\Implementations\Properties as PropertiesImp;
use Eightfold\XMLBuilder\Implementations\Buildable as BuildableImp;
use Eightfold\XMLBuilder\Implementations\Contentable as ContentableImp;

class Element implements Buildable, Contentable
{
    use PropertiesImp;
    use BuildableImp;
    use ContentableImp;

    private bool $omitEndTag = false;

    final private function __construct(
        private string $name,
        string|Stringable ...$content
    ) {
        $this->content = $content;
    }

    public function omitEndTag(): static
    {
        $this->omitEndTag = true;

        return $this;
    }

    protected function omitEndTagClosingString(): string
    {
        return ' />';
    }

    public function __toString(): string
    {
        return $this->opening() . implode('', $this->content) . $this->closing();
    }

    private function opening(): string
    {
        if ($this->shouldOmitEndTag()) {
            return '<' .
                $this->name .
                $this->propertiesString() .
                $this->omitEndTagClosingString();

        }
        return '<' . $this->name . $this->propertiesString() . '>';
    }

    private function shouldOmitEndTag(): bool
    {
        return $this->omitEndTag;
    }

    private function closing(): string
    {
        if ($this->shouldOmitEndTag()) {
            return '';

        }
        return '</' . $this->name . '>';
    }
}
