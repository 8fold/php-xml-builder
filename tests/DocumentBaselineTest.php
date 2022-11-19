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
    public function document_can_modify_declaration_properties(): void
    {
        $this->assertSame(
            '<?xml version="1.1" encoding="UTF-16" standalone="no" ?>' . "\n" .
            '<root></root>',
            (string) Document::create('root')
                ->setVersion(1.1)
                ->setEncoding('UTF-16')
                ->setStandalone(false)
        );

        $this->assertSame(
            '<?xml version="1.1" encoding="UTF-16" standalone="no" ?>' . "\n" .
            '<root></root>',
            (string) Document::create('root')
                ->setVersion('1.1')
                ->setEncoding('UTF-16')
                ->setStandalone(false)
        );

        $this->assertSame(
            '<?xml version="1.0" encoding="UTF-16" standalone="no" ?>' . "\n" .
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
        $this->assertSame(
            '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>'."\n".'<root id="6" property="hello"></root>',
            (string) Document::create('root')->props('id 6', 'property hello')
        );
    }

    /**
     *@test
     */
    public function document_can_have_comment(): void
    {
        $this->assertSame(
            '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>' .
            "\n" .
            '<root>' . "\n" .
            '<!-- comment -->' . "\n" .
            '<tag /></root>',
            Document::create(
                'root',
                Comment::create('comment'),
                Element::create('tag')->omitEndTag()
            )->build()
        );
    }

    /**
     *@test
     */
    public function document_can_have_properties(): void
    {
        $this->assertSame(
            '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>'."\n".'<root id="6" property="hello"></root>',
            Document::create('root')->props('id 6', 'property hello')->build()
        );
    }

    /**
     *@test
     */
    public function document_can_use_shorthand(): void
    {
        $this->assertSame(
            '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>'."\n".'<root><child><grandchild></grandchild><![CDATA[String]]></child></root>',
            Document::root(
                Element::child(
                    Element::grandchild(),
                    Cdata::create('String')
                )
            )->build()
        );
    }

    /**
     *@test
     */
    public function document_can_accept_content(): void
    {
        $this->assertSame(
            '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>'."\n".'<root><child><grandchild></grandchild><![CDATA[String]]></child></root>',
            Document::create(
                'root',
                Element::create('child',
                    Element::create('grandchild'),
                    Cdata::create('String')
                )
            )->build()
        );
    }

    /**
     *@test
     */
    public function document_can_initialized_statically(): void
    {
        $this->assertSame(
            '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>'."\n".'<tag></tag>',
            Document::create('tag')->build()
        );
    }
}
