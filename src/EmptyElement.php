<?php
declare(strict_types=1);

namespace Eightfold\XmlBuilder;

use Eightfold\XmlBuilder\PropertyInterface;

use Stringable;

use Eightfold\XmlBuilder\Element;
use Eightfold\XmlBuilder\Properties;

class EmptyElement implements PropertyInterface
{
    public static function create(string $name, string ...$properties): static
    {
        $properties = array_values($properties);
        return new static($name, $properties);
    }

    /**
     * @param  list<string>  $properties
     */
    public static function __callStatic(string $name, array $properties = []): static
    {
        return new static($name, $properties);
    }

    /**
     * @param  list<string>  $properties
     */
    final private function __construct(
        private string $name,
        private array $properties = [],
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

    public function toString(): string
    {
        return (string) Element::create($this->name)->omitEndTag()
            ->props(...$this->properties);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
