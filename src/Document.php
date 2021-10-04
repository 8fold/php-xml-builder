<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder;

// use \Stringable;

// TODO: PHP8 - specify implementing Stringable
class Document // implements Stringable
{
    private string $rootName;

    /**
     * @var array<Element|string>
     */
    private array $content = [];

    /**
     * @var array<string>
     */
    private array $properties = [];

    /**
     * @param  Element|string $content
     */
    public static function create(string $rootName, ...$content): Document
    {
        return new Document($rootName, ...$content);
    }

    /**
     * @param string $rootName <{$rootName}>
     *                         PHP8: auto-assign local variable
     * @param Element|string $content Content within tags.
     *                                PHP8: union type to Element|string
     */
    public function __construct(string $rootName, ...$content)
    {
        $this->rootName = $rootName;
        $this->content     = $content;
    }

    public function props(string ...$properties): Document
    {
        $this->properties = $properties;

        return $this;
    }

    public function build(): string
    {
        $doctype = '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>' . "\n";
        return $doctype . $this->opening() . $this->contentString() . $this->closing();
    }

    public function __toString(): string
    {
        return $this->build();
    }

    private function opening(): string
    {
        return '<' . $this->rootName() . $this->propertiesString() . '>';
    }

    private function propertiesString(): string
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

    /**
     * @return array<string>
     */
    public function properties(): array
    {
        return $this->properties;
    }

    private function closing(): string
    {
        return '</' . $this->rootName() . '>';
    }

    private function rootName(): string
    {
        return $this->rootName;
    }

    /**
     * @return array<Element|string> [description]
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
