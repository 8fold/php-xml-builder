<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use Eightfold\XMLBuilder\Element;

class ElementBaselineTest extends TestCase
{
    #[Test]
    public function element_can_omit_end_tag(): void
    {
        parent::assertSame(
            '<root id="6" property="hello" />',
            (string) Element::create('root')->props('id 6', 'property hello')
                ->omitEndTag()
        );
    }

    #[Test]
    public function element_can_have_properties(): void
    {
        // basic
        parent::assertSame(
            '<root id="6" property="hello"></root>',
            (string) Element::create('root')->props('id 6', 'property hello')
        );

        // add
        parent::assertSame(
            '<root id="6" property="hello" class="something"></root>',
            (string) Element::create('root')
                ->props('id 6', 'property hello')
                ->prop('class something')
        );
    }

    #[Test]
    public function element_can_use_shorthand(): void
    {
        parent::assertSame(
            '<root><child><grandchild name="Xavier" />Xavier<!CDATA[String]]></child></root>',
            (string) Element::root(
                Element::child(
                    Element::grandchild('Xavier')->omitEndTag()
                        ->props('name Xavier'),
                    '<!CDATA[String]]>'
                )
            )
        );
    }

    #[Test]
    public function element_can_accept_content(): void
    {
        parent::assertSame(
            '<root><child><grandchild></grandchild><!CDATA[String]]></child></root>',
            (string) Element::create(
                'root',
                Element::create(
                    'child',
                    Element::create('grandchild'),
                    '<!CDATA[String]]>'
                )
            )
        );
    }

    #[Test]
    public function element_can_be_initialized_statically(): void
    {
        parent::assertSame(
            '<tag></tag>',
            (string) Element::create('tag')
        );
    }
}
