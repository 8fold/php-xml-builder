<?php

declare(strict_types=1);

namespace Eightfold\XmlBuilder_;

use Stringable;

use Eightfold\XmlBuilder_\Contracts\Contentable;

use Eightfold\XmlBuilder_\Concatenate;

use Eightfold\XmlBuilder_\Implementations\Properties as PropertiesImp;
use Eightfold\XmlBuilder_\Implementations\Contentable as ContentableImp;

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
