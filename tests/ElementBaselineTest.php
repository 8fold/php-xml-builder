<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\XMLBuilder\Element;

class ElementBaselineTest extends TestCase
{
    /**
     *@test
     */
    public function element_is_stringable(): void
    {
        $this->assertEquals(
            (string) Element::create('root')->props('id 6', 'property hello')
                ->omitEndTag(),
            '<root id="6" property="hello" />'
        );
    }

    /**
     *@test
     */
    public function element_can_omit_end_tag(): void
    {
        $this->assertEquals(
            Element::create('root')->props('id 6', 'property hello')
                ->omitEndTag()->build(),
            '<root id="6" property="hello" />'
        );
    }

    /**
     *@test
     */
    public function element_can_have_properties(): void
    {
        $this->assertEquals(
            Element::create('root')->props('id 6', 'property hello')->build(),
            '<root id="6" property="hello"></root>'
        );
    }

    /**
     *@test
     */
    public function element_can_use_shorthand(): void
    {
        $this->assertEquals(
            Element::root(
                Element::child(
                    Element::grandchild('Xavier')->omitEndTag()
                        ->props('name Xavier'),
                    '<!CDATA[String]]>'
                )
            )->build(),
            '<root><child><grandchild name="Xavier" />Xavier<!CDATA[String]]></child></root>'
        );
    }

    /**
     *@test
     */
    public function element_can_accept_content(): void
    {
        $this->assertEquals(
            Element::create('root',
                Element::create('child',
                    Element::create('grandchild'),
                    '<!CDATA[String]]>'
                )
            )->build(),
            '<root><child><grandchild></grandchild><!CDATA[String]]></child></root>'
        );
    }

    /**
     *@test
     */
    public function element_can_be_initialized_statically(): void
    {
        $this->assertEquals(
            Element::create('tag')->build(),
            '<tag></tag>'
        );
    }

    /**
     *@test
     */
    public function element_exists(): void
    {
        $this->assertTrue(class_exists(Element::class));
    }
}
