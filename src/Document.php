<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder;

use Eightfold\XMLBuilder\Contracts\Buildable;
use Eightfold\XMLBuilder\Contracts\Contentable;

use Stringable;

use Eightfold\XMLBuilder\Concatenate;

use Eightfold\XMLBuilder\Callables\PropertyArrayToString;

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

    public function removeEncoding(): self
    {
        $this->encoding = '';
        return $this;
    }

    public function setStandalone(bool $standalone = true): self
    {
        $this->standalone = ($standalone) ? 'yes' : 'no';
        return $this;
    }

    public function removeStandalone(): self
    {
        $this->standalone = '';
        return $this;
    }

    public function __toString(): string
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
            '<?xml' . PropertyArrayToString::convert(...$declarationProps) . ' ?>'
            . "\n";
        return $doctype
            . $this->opening()
            . Concatenate::create(...$this->content)
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
