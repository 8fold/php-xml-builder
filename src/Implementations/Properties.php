<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder\Implementations;

trait Properties
{
    /**
     * @var array<string>
     */
    private array $properties = [];

    public function props(string ...$properties): static
    {
        $this->properties = $properties;
        return $this;
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

    /**
     * @return array<string> [description]
     */
    protected function properties(): array
    {
        return $this->properties;
    }
}
