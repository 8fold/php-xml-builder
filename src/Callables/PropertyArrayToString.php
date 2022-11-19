<?php
declare(strict_types=1);

namespace Eightfold\XMLBuilder\Callables;

class PropertyArrayToString
{
    public static function convert(string ...$properties): string
    {
        $instance = new self;
        return $instance(...$properties);
    }

    public function __invoke(string ...$properties): string
    {
        $b = [];
        foreach ($properties as $property) {
            $property = explode(' ', $property, 2);
            $b[] = $property[0] . '="' . $property[1] . '"';

        }

        return ' ' . implode(' ', $b);
    }
}
