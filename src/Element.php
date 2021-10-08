<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder;

// use \Stringable;

// TODO: PHP8 - specify implementing Stringable
class Element // implements Stringable
{
    private string $elementName;

    private bool $omitEndTag = false;

    /**
     * @var array<Element|string>
     */
    private array $content = [];

    /**
     * @var array<string>
     */
    private array $properties = [];

    /**
     * @param  string $elementName
     * @param  array<Element|string>  $content
     */
    public static function __callStatic(string $elementName, $content = []): Element
    {
        return static::create($elementName, ...$content);
    }

    /**
     * @param  Element|string $content
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

    public function props(string ...$properties): Element
    {
        $this->properties = $properties;

        return $this;
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

    protected function propertiesString(): string
    {
        if (count($this->properties()) === 0) {
            return '';

        }

        $b = [];
        foreach ($this->properties() as $property) {
            $property = explode(' ', $property, 2);
            $b[] = $property[0] . '="' . $property[1] . '"';

        }

        return ' ' . implode(' ', $b);
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

    /**
     * @return array<string> [description]
     */
    private function properties(): array
    {
        return $this->properties;
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
