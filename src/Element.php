<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder;

use Stringable;

use Eightfold\XMLBuilder\Contracts\Contentable;

use Eightfold\XMLBuilder\Concatenate;

use Eightfold\XMLBuilder\Implementations\Properties as PropertiesImp;
use Eightfold\XMLBuilder\Implementations\Contentable as ContentableImp;

class Element implements Stringable, Contentable
{
    use PropertiesImp;
    use ContentableImp;

    private bool $omitEndTag = false;

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
        return $this->opening()
            . Concatenate::create(...$this->content)
            . $this->closing();
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
