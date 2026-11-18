<?php

declare(strict_types=1);

namespace Eightfold\XmlBuilder;

use Eightfold\XmlBuilder\PropertyInterface;

use Stringable;

use Eightfold\XmlBuilder\Properties;

class Document implements PropertyInterface
{
    private string $version = '1.0';

    private string $encoding = 'UTF-8';

    private string $standalone = 'yes';

    public static function create(
        string $name,
        string|Stringable ...$content
    ): static {
        return new static($name, $content);
    }

    /**
     * @param array<string|Stringable> $content
     * @return static
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
        private array $properties = []
    ) {
    }

    public function withVersion(string|float|int $version): static
    {
        if (is_int($version)) {
            $version = strval($version) . '.0';
        }
        $this->version = strval($version);
        return $this;
    }

    public function withEncoding(string $encoding): static
    {
        $this->encoding = $encoding;
        return $this;
    }

    public function removeEncoding(): static
    {
        $this->encoding = '';
        return $this;
    }

    public function withStandalone(bool $standalone): static
    {
        $this->standalone = ($standalone) ? 'yes' : 'no';
        return $this;
    }

    public function removeStandalone(): static
    {
        $this->standalone = '';
        return $this;
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
        $declarationProps = [];
        $declarationProps[] = 'version ' . $this->version;

        if (strlen($this->encoding) > 0) {
            $declarationProps[] = 'encoding ' . $this->encoding;
        }

        if (strlen($this->standalone) > 0) {
            $declarationProps[] = 'standalone ' . $this->standalone;
        }

        $doctype =
            '<?xml' . Properties::compile($declarationProps) . ' ?>'
            . "\n";
        return $doctype
            . self::opening()
            . implode('', array_map('strval', $this->content))
            . self::closing();
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    private function opening(): string
    {
        return '<' . $this->name . Properties::compile($this->properties) . '>';
    }

    private function closing(): string
    {
        return '</' . $this->name . '>';
    }
}
