<?php

declare(strict_types=1);

namespace Eightfold\XMLBuilder\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;
use Eightfold\XMLBuilder\Cdata;
use Eightfold\XMLBuilder\Comment;

class DocumentBaselineTest extends TestCase
{
    /**
     * @test
     */
    public function document_can_modify_doctype_properties(): void
    {
        $this->assertSame(
            '<?xml version = "1.1" encoding = "UTF-16" standalone = "no" ?>' . "\n" .
            '<root></root>',
            (string) Document::create('root')
                ->setVersion(1.1)
                ->setEncoding('UTF-16')
                ->setStandalone(false)
        );

        $this->assertSame(
            '<?xml version = "1.1" encoding = "UTF-16" standalone = "no" ?>' . "\n" .
            '<root></root>',
            (string) Document::create('root')
                ->setVersion('1.1')
                ->setEncoding('UTF-16')
                ->setStandalone(false)
        );

        $this->assertSame(
            '<?xml version = "1.0" encoding = "UTF-16" standalone = "no" ?>' . "\n" .
            '<root></root>',
            (string) Document::create('root')
                ->setVersion(1)
                ->setEncoding('UTF-16')
                ->setStandalone(false)
        );
    }

    /**
     *@test
     */
    public function document_is_stringable(): void
    {
        $this->assertEquals(
            (string) Document::create('root')->props('id 6', 'property hello'),
            '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>'."\n".'<root id="6" property="hello"></root>'
        );
    }

    /**
     *@test
     */
    public function document_can_have_comment(): void
    {
        $this->assertEquals(
            Document::create(
                'root',
                Comment::create('comment'),
                Element::create('tag')->omitEndTag()
            )->build(),
            '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>' .
            "\n" .
            '<root>' . "\n" .
            '<!-- comment -->' . "\n" .
            '<tag /></root>'
        );
    }

    /**
     *@test
     */
    public function document_can_have_properties(): void
    {
        $this->assertEquals(
            Document::create('root')->props('id 6', 'property hello')->build(),
            '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>'."\n".'<root id="6" property="hello"></root>'
        );
    }

    /**
     *@test
     */
    public function document_can_use_shorthand(): void
    {
        $this->assertEquals(
            Document::root(
                Element::child(
                    Element::grandchild(),
                    Cdata::create('String')
                )
            )->build(),
            '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>'."\n".'<root><child><grandchild></grandchild><![CDATA[String]]></child></root>'
        );
    }

    /**
     *@test
     */
    public function document_can_accept_content(): void
    {
        $this->assertEquals(
            Document::create('root',
                Element::create('child',
                    Element::create('grandchild'),
                    Cdata::create('String')
                )
            )->build(),
            '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>'."\n".'<root><child><grandchild></grandchild><![CDATA[String]]></child></root>'
        );
    }

    /**
     *@test
     */
    public function document_can_initialized_statically(): void
    {
        $this->assertEquals(
            Document::create('tag')->build(),
            '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>'."\n".'<tag></tag>'
        );
    }

    /**
     *@test
     */
    public function document_exists(): void
    {
        $this->assertTrue(class_exists(Document::class));
    }
}
