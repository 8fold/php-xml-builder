<?php
declare(strict_types=1);

namespace Eightfold\XmlBuilder;

final class Properties
{
    public const ORDERED = [];

    /**
     * @param  list<string>  $properties
     * @param  list<string>  $ordered
     */
    public static function compile(
        array $properties,
        array $ordered = self::ORDERED
    ): string {
        if ($properties === []) {
            return '';
        }

        $orderd = [];
        $props  = [];
        foreach ($properties as $property) {
            [$prop, $value] = array_pad(explode(' ', strval($property), 2), 2, '');

            if (in_array($prop, $ordered, true)) {
                $ordered[$prop] = $value;
                continue;
            }
            $props[$prop] = $value;
        }

        $parts = [];

        foreach ($ordered as $prop) {
            if (isset($ordered[$prop])) {
                $parts[] = $prop . '="' . $ordered[$prop] . '"';
            }
        }

        ksort($props);
        foreach ($props as $prop => $value) {
            $parts[] = $prop . '="' . $value . '"';
        }

        return $parts === [] ? '' : ' ' . implode(' ', $parts);
    }

    final private function __construct()
    {
    }
}
