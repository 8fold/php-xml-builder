<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder;

// use \Stringable;

// TODO: PHP8 - specify implementing Stringable
class Cdata // implements Stringable
{
    private string $content = '';

    public static function create(string $content): Cdata
    {
        return new Cdata($content);
    }

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function build(): string
    {
        return '<![CDATA[' . $this->content() . ']]>';
    }

    public function __toString(): string
    {
        return $this->build();
    }


    private function content(): string
    {
        return $this->content;
    }
}
