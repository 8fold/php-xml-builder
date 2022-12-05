<?php
declare(strict_types=1);

namespace Eightfold\XMLBuilder;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Stringable;

use Eightfold\XMLBuilder\Implementations\Buildable as BuildableImp;

class Concatenate implements Buildable
{
    use BuildableImp;

    /**
     * @var array<string|Stringable>
     */
    private array $content = [];

    public static function create(string|Stringable ...$content): self
    {
        return new self(...$content);
    }

    final private function __construct(string|Stringable ...$content)
    {
        $this->content = $content;
    }

    public function __toString(): string
    {
        return implode('', $this->content);
    }
}
