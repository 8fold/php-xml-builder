# 8fold XML Builder for PHP

XML Builder is designed to build a `string`, not a document object model (DOM)
or abstract syntax tree (AST).

For DOM or AST, there are other libraries and native implementations (ex. [PHP:DOM](https://www.php.net/manual/en/book.dom.php) and [SimpleXML](https://www.php.net/manual/en/simplexml.examples-basic.php)).

You might use XML Builder to generate a string you feed into either PHP:DOM or
Simple XML. Or, use the string as the body of an HTTP response.

Use the `Element` class to create individual nodes within the document.

Use the `Document` class to generate the doctype declaration and root level element.

## Installation

`composer require 8fold/php-xml-builder`

## Usage

Warning: Users of this library are responsible for sanitizing content.

```php
use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;
use Eightfold\XMLBuilder\Cdata;

echo Document::create('root',
  Element::create('child',
    Element::create('grandchild')->omitEndTag()->props('name Xavier'),
    Cdata::create('Hello, my name is Xavier!')
  )
);
```

Output:

```xml
<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
<root><child><grandchild name="Xavier"/><![CDATA[Hello, my name is Xavier!]]></child></root>
```
Output (formatted):

```xml
<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
<root>
  <child>
    <grandchild name="Xavier"/>
    <![CDATA[Hello, my name is Xavier!]]>
  </child>
</root>
```

Alternatively, there is a shorthand variation.

The shorthand method uses the `__callStatic` PHP magic method.

```php
use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;
use Eightfold\XMLBuilder\Cdata;

echo Document::root(
  Element::child(
    Element::grandchild()->omitEndTag()->props('name Xavier'),
    Cdata::create('Hello, my name is Xavier!')
  )
);

// output: Same as previous example.
```

Comments are available:

```php
use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;
use Eightfold\XMLBuilder\Cdata;

echo Document::create(
  'root',
  Comment::create('comment'),
  Element::create('tag')->omitEndTag()
);
```

Output (unformatted):

```xml
<?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>
<root>
<!-- comment -->
<tag /></root>
```

### Compatibility

|XML Builder version |PHP version |
|:------------------:|:----------:|
|1+                  |8.0+        |
|0+                  |7.4+        |

## Details

The origins of this library was an experiment where PHP was viewed as a "pure" programming language, not a template engine that grew into being a language.

The primary pain point was to maintain the feel of writing human-readable XML (tabs and spaces) while reducing the risk of human error; specifically, mismatched beginning and end tags.

The secondary pain point was that PHP:DOM and SimpleXML felt cumbersome when generating XML and HTML documents.

## Other

- [Code of Conduct](https://github.com/8fold/php-xml-builder/blob/master/.github/CODE_OF_CONDUCT.md)
- [Contributing](https://github.com/8fold/php-xml-builder/blob/master/.github/CONTRIBUTING.md)
- [Governance](https://github.com/8fold/php-xml-builder/blob/master/.github/GOVERNANCE.md)
- [Versioning](https://github.com/8fold/php-xml-builder/blob/master/.github/VERSIONING.md)
- [Security](https://github.com/8fold/php-xml-builder/blob/master/.github/SECURITY.md)
