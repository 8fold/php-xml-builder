<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder\Implementations;

use Eightfold\XMLBuilder\Callables\PropertyArrayToString;

trait Properties
{
    /**
     * @var array<string>
     */
    private array $properties = [];

    /**
     * @return static $properties [description]
     */
    public function props(string ...$properties): static
    {
        $this->properties = $properties;
        return $this;
    }

    public function prop(string $prop): static
    {
        $this->properties[] = $prop;
        return $this;
    }

    protected function propertiesString(): string
    {
        $props = $this->properties();
        if (count($props) === 0) {
            return '';
        }
        return PropertyArrayToString::convert(...$props);
    }

    /**
     * @return array<string> [description]
     */
    protected function properties(): array
    {
        return $this->properties;
    }
}
