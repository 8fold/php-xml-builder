<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder;

use Stringable;

use Eightfold\XMLBuilder\Contracts\Buildable;
use Eightfold\XMLBuilder\Contracts\Contentable;

use Eightfold\XMLBuilder\Implementations\Properties as PropertiesImp;
use Eightfold\XMLBuilder\Implementations\Buildable as BuildableImp;
use Eightfold\XMLBuilder\Implementations\Contentable as ContentableImp;

class Document implements Buildable, Contentable
{
    use PropertiesImp;
    use BuildableImp;
    use ContentableImp;

    private string $version = '1.0';

    private string $encoding = 'UTF-8';

    private string $standalone = 'yes';

    final private function __construct(
        private string $name,
        string|Stringable ...$content
    ) {
        $this->content  = $content;
    }

    public function setVersion(string|float|int $version): self
    {
        if (is_int($version)) {
            $version = strval($version) . '.0';
        }
        $this->version = strval($version);
        return $this;
    }

    public function setEncoding(string $encoding): self
    {
        $this->encoding = $encoding;
        return $this;
    }

    public function setStandalone(bool $standalone = true): self
    {
        $this->standalone = ($standalone) ? 'yes' : 'no';
        return $this;
    }

    public function __toString(): string
    {
        $doctype =
            '<?xml version = "' . $this->version . '" encoding = "' . $this->encoding . '" standalone = "' . $this->standalone . '" ?>'
            . "\n";
        return $doctype . $this->opening() . implode('', $this->content)
            . $this->closing();
    }

    private function opening(): string
    {
        return '<' . $this->name . $this->propertiesString() . '>';
    }

    private function closing(): string
    {
        return '</' . $this->name . '>';
    }
}
