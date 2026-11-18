<?php

declare(strict_types=1);

namespace Eightfold\XmlBuilder\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\XmlBuilder\Document;
use Eightfold\XmlBuilder\Element;
use Eightfold\XmlBuilder\EmptyElement;
use Eightfold\XmlBuilder\Cdata;
use Eightfold\XmlBuilder\Comment;

class DocumentBaselineTest extends TestCase
{
    public function test_document_can_remove_optional_declaration_props(): void
    {
        parent::assertSame(
            '<?xml version="1.0" ?>' . "\n" . '<root></root>',
            (string) Document::create('root')
                ->removeEncoding()
                ->removeStandalone()
        );
    }

    public function test_document_can_modify_declaration_properties(): void
    {
        parent::assertSame(
            '<?xml encoding="UTF-16" standalone="no" version="1.1" ?>' . "\n" .
            '<root></root>',
            (string) Document::create('root')
                ->withVersion(1.1)
                ->withEncoding('UTF-16')
                ->withStandalone(false)
        );

        parent::assertSame(
            '<?xml encoding="UTF-16" standalone="no" version="1.1" ?>' . "\n" .
            '<root></root>',
            (string) Document::create('root')
                ->withVersion('1.1')
                ->withEncoding('UTF-16')
                ->withStandalone(false)
        );

        parent::assertSame(
            '<?xml encoding="UTF-16" standalone="no" version="1.0" ?>' . "\n" .
            '<root></root>',
            (string) Document::create('root')
                ->withVersion(1)
                ->withEncoding('UTF-16')
                ->withStandalone(false)
        );
    }

    public function test_document_can_have_comment(): void
    {
        parent::assertSame(
            '<?xml encoding="UTF-8" standalone="yes" version="1.0" ?>' .
            "\n" .
            '<root>' . "\n" .
            '<!-- comment -->' . "\n" .
            '<tag /></root>',
            (string) Document::create(
                'root',
                Comment::create('comment'),
                Element::create('tag')->omitEndTag()
            )
        );
    }

    public function test_document_can_have_properties(): void
    {
        parent::assertSame(
            '<?xml encoding="UTF-8" standalone="yes" version="1.0" ?>' . "\n"
            . '<root id="6" property="hello"></root>',
            (string) Document::create('root')->props('id 6', 'property hello')
        );
    }

    public function test_document_can_use_shorthand(): void
    {
        parent::assertSame(
            '<?xml encoding="UTF-8" standalone="yes" version="1.0" ?>' . "\n"
            . '<root><child><grandchild></grandchild><![CDATA[String]]></child></root>',
            (string) Document::root(
                Element::child(
                    Element::grandchild(),
                    Cdata::create('String')
                )
            )
        );
    }

    public function test_document_can_accept_content(): void
    {
        parent::assertSame(
            '<?xml encoding="UTF-8" standalone="yes" version="1.0" ?>' . "\n"
            . '<root><child><grandchild /><![CDATA[String]]></child></root>',
            Document::create(
                'root',
                Element::create(
                    'child',
                    EmptyElement::grandchild(),
                    Cdata::create('String')
                )
            )->toString()
        );
    }

    public function test_document_can_initialized_statically(): void
    {
        parent::assertSame(
            '<?xml encoding="UTF-8" standalone="yes" version="1.0" ?>' . "\n" . '<tag></tag>',
            (string) Document::create('tag')
        );
    }
}
