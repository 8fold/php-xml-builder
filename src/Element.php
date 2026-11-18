<?php
declare(strict_types=1);

namespace Eightfold\XmlBuilder;

use Eightfold\XmlBuilder\PropertyInterface;

use Stringable;

use Eightfold\XmlBuilder\Properties;

class Element implements PropertyInterface
{
    public static function create(string $name, string|Stringable ...$content): static
    {
        return new static($name, $content);
    }

    /**
     * @param array<string|Stringable>  $content
     */
    public static function __callStatic(string $name, array $content = []): static
    {
        return new static($name, $content);
    }

    /**
     * @param  array<string|Stringable>  $content
     * @param  list<string>  $properties
     */
    final private function __construct(
        private string $name,
        private array $content = [],
        private array $properties = [],
        private bool $omitEndTag = false,
    ) {
    }

    public function props(string ...$properties): static
    {
        $this->properties = array_values($properties);
        return $this;
    }

    public function prop(string $prop): static
    {
        $this->properties[] = $prop;
        return $this;
    }

    public function omitEndTag(): static
    {
        $this->omitEndTag = true;
        return $this;
    }

    public function toString(): string
    {
        return self::opening()
            . implode('', array_map('strval', $this->content))
            . self::closing();
    }

    public function __toString(): string
    {
        return self::toString();
    }

    private function opening(): string
    {
        if ($this->omitEndTag) {
            return '<' .
                $this->name .
                Properties::compile($this->properties) .
                ' />';

        }
        return '<' . $this->name . Properties::compile($this->properties) . '>';
    }

    private function closing(): string
    {
        if ($this->omitEndTag) {
            return '';

        }
        return '</' . $this->name . '>';
    }
}
