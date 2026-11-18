<?php

declare(strict_types=1);

namespace Eightfold\XmlBuilder\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\XmlBuilder\Element;

class ElementBaselineTest extends TestCase
{
    public function test_element_can_omit_end_tag(): void
    {
        parent::assertSame(
            '<root id="6" property="hello" />',
            (string) Element::create('root')->props('id 6', 'property hello')
                ->omitEndTag()
        );
    }

    public function test_element_can_have_properties(): void
    {
        // basic
        parent::assertSame(
            '<root id="6" property="hello"></root>',
            (string) Element::create('root')->props('id 6', 'property hello')
        );

        // add
        parent::assertSame(
            '<root class="something" id="6" property="hello"></root>',
            (string) Element::create('root')
                ->props('id 6', 'property hello')
                ->prop('class something')
        );
    }

    public function test_element_can_use_shorthand(): void
    {
        $result = (string) Element::root(
            Element::child(
                Element::grandchild('Xavier')->omitEndTag() // L43
                    ->props('name Xavier'), // L44
                '<!CDATA[String]]>'
            )
        );

        parent::assertSame(
            '<root><child><grandchild name="Xavier" />Xavier<!CDATA[String]]></child></root>',
            $result
        );
    }

    public function test_element_can_accept_content(): void
    {
        parent::assertSame(
            '<root><child><grandchild></grandchild><!CDATA[String]]></child></root>',
            Element::create(
                'root',
                Element::create(
                    'child',
                    Element::create('grandchild'),
                    '<!CDATA[String]]>'
                )
            )->toString()
        );
    }

    public function test_element_can_be_initialized_statically(): void
    {
        parent::assertSame(
            '<tag></tag>',
            (string) Element::create('tag')
        );
    }
}
