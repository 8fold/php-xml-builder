<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder;

use Eightfold\XMLBuilder\Contracts\Buildable;
use Eightfold\XMLBuilder\Implementations\Properties as PropertiesImp;

// use \Stringable;

// TODO: PHP8 - specify implementing Stringable
class Element implements Buildable // implements Stringable
{
    use PropertiesImp;

    private string $elementName;

    private bool $omitEndTag = false;

    /**
     * @var array<Element|string>
     */
    private array $content = [];

    /**
     * @param string $elementName
     * @param array<Element|string> $content
     */
    public static function __callStatic(
        string $elementName,
        $content = []
    ): Element {
        return static::create($elementName, ...$content);
    }

    /**
     * @param Element|string $content
     */
    public static function create(string $elementName, ...$content): Element
    {
        return new static($elementName, ...$content);
    }

    /**
     * @param string $elementName <{$elementName}>
     *                            PHP8: auto-assign local variable
     * @param Element|string $content Content within tags.
     *                                PHP8: union type to Element|string
     */
    final public function __construct(string $elementName, ...$content)
    {
        $this->elementName = $elementName;
        $this->content     = $content;
    }

    public function omitEndTag(): Element
    {
        $this->omitEndTag = true;

        return $this;
    }

    protected function omitEndTagClosingString(): string
    {
        return ' />';
    }

    /**
     * @return array<string> [description]
     */
    protected function properties(): array
    {
        return $this->properties;
    }

    public function build(): string
    {
        return $this->opening() . $this->contentString() . $this->closing();
    }

    public function __toString(): string
    {
        return $this->build();
    }

    private function opening(): string
    {
        if ($this->shouldOmitEndTag()) {
            return '<' .
                $this->elementName() .
                $this->propertiesString() .
                $this->omitEndTagClosingString();

        }
        return '<' . $this->elementName() . $this->propertiesString() . '>';
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
        return '</' . $this->elementName() . '>';
    }

    private function elementName(): string
    {
        return $this->elementName;
    }

    /**
     * @return array<Element|string>
     */
    private function content(): array
    {
        return $this->content;
    }

    private function contentString(): string
    {
        $b = '';
        foreach ($this->content() as $inner) {
            $b .= (is_a($inner, Element::class))
                ? $inner->build()
                : $inner;

        }
        return $b;
    }
}
