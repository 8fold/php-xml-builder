# 8fold XML Builder for PHP

XML Builder is designed to build a `string`, not a document object model (DOM) or abstract syntax tree (AST).

Warning: Users of this library are responsible for sanitizing content.

For DOM or AST, there are other libraries and native implementations (ex. [PHP:DOM](https://www.php.net/manual/en/book.dom.php) and [SimpleXML](https://www.php.net/manual/en/simplexml.examples-basic.php)).

You might use XML Builder to generate a string you feed into either PHP:DOM or Simple XML. Or, use the string as the body of an HTTP response.

- [Installation](#installation)
- [Usage](#usage)
  - [`Element⁣`](#element)
  - [`EmptyElement`](#emptyelement)
  - [`Document`](#document)
  - [`Cdata`](#cdata)
  - [`Comment`](#comment)
  - [Properties](#properties)⁣
- [Extending](#extending)⁣
- [Compatibility](#compatibility)⁣
- [Details](#details)
- [Other](#other)⁣

Use the `Element` class to create individual nodes within the document.

Use the `Document` class to generate the doctype declaration and root level element.

## Installation

`composer require 8fold/php-xml-builder`

## Usage

### `Element`

The fundamental building block for all output.

```php
use Eightfold\XmlBuilder\Element;

// non-empty element, using `create()`
Element::create('xml_tag', 'Hello, World!')->props('id intro');
```

Output:
```html
<xml_tag id="intro">Hello, World!</p>
```

Non-empty element using magic method:
```php
Element::xml_tag('Hello, World!')->props('id intro');
```

Output:
```html
<xml_tag id="intro">Hello, World!</p>
```

Empty element using magic method:
```php
Element::xml_tag()->omitEndTag()->props('src /path/to/image.png');
```

Output:
```html
<xml_tag src="/path/to/image.php" />
```

### `EmptyElement`

The [`EmptyElement`](https://github.com/8fold/php-xml-builder/blob/main/src/EmptyElement.php) class was introduced in the 4.0 release and is designed to mirror the input shorthand of HTML those elements compared to using the `Element` class to do the same.

```php
use Eightfold\XmlBuilder\Element;
use Eightfold\XmlBuilder\EmptyElement;

Element::xml_tag()->omitEndTag()->props('src /path/to/image.png');
```

Output:

```html
<xml_tag src="/path/to/image.php" />
```

Using `EmptyElement`:

```php
EmptyElement::xml_tag('src /path/to/image.png');

// output same as previous
```

### `Document`

The [`Document`](https://github.com/8fold/php-html-builder/blob/main/src/Document.php) class gives you to generate a complete XML document entirely in PHP.

```php
use Eightfold\XmlBuilder\Document;
use Eightfold\XmlBuilder\Element;
use Eightfold\XmlBuilder\EmptyElement;
use Eightfold\XmlBuilder\Cdata;

echo Document::root(
  Element::child(
    EmptyElement::grandchild('name Xavier'),
    Cdata::create('Hello, my name is Xavier!')
  )
);
```

Output

```xml
<!-- compressed -->
<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
<root><child><grandchild name="Xavier"/><![CDATA[Hello, my name is Xavier!]]></child></root>

<!-- human-readable -->
<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
<root>
  <child>
    <grandchild name="Xavier"/>
    <![CDATA[Hello, my name is Xavier!]]>
  </child>
</root>
```

Further examples are in the [`tests`](https://github.com/8fold/php-xml-builder/tree/main/tests) folder with an example extension.

### `Cdata`

The [`Cdata`](https://github.com/8fold/php-xml-builder/blob/main/src/Cdata.php) class allows you to insert literal text within an XML document.

See [`Document`](#document).


### `Comment`

There’s even a [`Comment`](https://github.com/8fold/php-xml-builder/blob/main/src/Comment.php) component for adding inline XML comments.

```php
use Eightfold\XmlBuilder\Document;
use Eightfold\XmlBuilder\Element;
use Eightfold\XmlBuilder\EmptyElement;
use Eightfold\XmlBuilder\Cdata;
use Eightfold\XmlBuilder\Comment;

echo Document::root(
  Element::child(
    EmptyElement::grandchild('name Xavier'),
    Comment::create('This is a comment')
  )
);
```

```xml
<!-- compressed -->
<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
<root><child><grandchild name="Xavier"/><!-- This is a comment --></child></root>

<!-- human-readable -->
<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
<root>
    <child>
        <grandchild name="Xavier"/>
        <!-- This is a comment -->
    </child>
</root>
```

## Extending

Each XML Builder component accepts string literals and classes that implement the PHP-native `Stringable` interface. Further, XML Builder provides the [`PropertyInterface`](https://github.com/8fold/php-xml-builder/blob/main/src/PropertyInterface.php), which extends the `Stringable` interface. Therefore, XML Builder allows developers to create custom components and APIs without extending XML Builder’s base components.

### Compatibility

|XML Builder version |PHP version |
|:------------------:|:----------:|
|4+                  |8.0+        |
|3+                  |8.4+        |
|1+                  |8.0+        |
|0+                  |7.4+        |

Note: v3 to v4 opens support to backward compatibility on PHP versions; mainly we determined that the PHP 8.4+ capabilities were unnecessary — at least for now.

## Details

> See [8fold HTML Builder](https://github.com/8fold/php-html-builder) for PHP HTML Builder’s sibling.

The origins of this library was an experiment where PHP was viewed as a "pure" programming language, not a template engine that grew into being a language.

The primary pain point was to maintain the feel of writing human-readable XML (tabs and spaces) while reducing the risk of human error; specifically, mismatched beginning and end tags.

The secondary pain point was that PHP:DOM and SimpleXML felt cumbersome when generating XML and HTML documents.

## Other

- [Code of Conduct](https://github.com/8fold/.github/blob/main/CODE_OF_CONDUCT.md)
- [Contributing](https://github.com/8fold/.github/blob/main/CONTRIBUTING.md)
- [Governance](https://github.com/8fold/.github/blob/main/GOVERNANCE.md)
- [Versioning](https://github.com/8fold/.github/blob/main/docs/versioning-base.md)
- [Security](https://github.com/8fold/.github/blob/main/SECURITY.md)
