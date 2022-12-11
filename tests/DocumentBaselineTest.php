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
    public function document_can_remove_optional_declaration_props(): void
    {
        $this->assertSame(
            '<?xml version="1.0" ?>' . "\n" . '<root></root>',
            (string) Document::create('root')
                ->removeEncoding()
                ->removeStandalone()
        );
    }

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
            (string) Document::create(
                'root',
                Comment::create('comment'),
                Element::create('tag')->omitEndTag()
            )
        );
    }

    /**
     *@test
     */
    public function document_can_have_properties(): void
    {
        $this->assertSame(
            '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>'."\n".'<root id="6" property="hello"></root>',
            (string) Document::create('root')->props('id 6', 'property hello')
        );
    }

    /**
     *@test
     */
    public function document_can_use_shorthand(): void
    {
        $this->assertSame(
            '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>'."\n".'<root><child><grandchild></grandchild><![CDATA[String]]></child></root>',
            (string) Document::root(
                Element::child(
                    Element::grandchild(),
                    Cdata::create('String')
                )
            )
        );
    }

    /**
     *@test
     */
    public function document_can_accept_content(): void
    {
        $this->assertSame(
            '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>'."\n".'<root><child><grandchild></grandchild><![CDATA[String]]></child></root>',
            (string) Document::create(
                'root',
                Element::create('child',
                    Element::create('grandchild'),
                    Cdata::create('String')
                )
            )
        );
    }

    /**
     *@test
     */
    public function document_can_initialized_statically(): void
    {
        $this->assertSame(
            '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>'."\n".'<tag></tag>',
            (string) Document::create('tag')
        );
    }
}
