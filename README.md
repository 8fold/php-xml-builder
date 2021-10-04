# 8fold XML Builder

XML Builder is designed to build a `string`, not a document object model (DOM)
or abstract syntax tree (AST). If you are looking to achieve either a DOM or AST,
there are other libraries and native implementations to do so
([PHP : DOM](https://www.php.net/manual/en/simplexml.examples-basic.php) and [SimpleXML](https://www.php.net/manual/en/simplexml.examples-basic.php), for example).

You might use XML Builder to generate a string you feed into either PHP:DOM or Simple XML.

The `Element` class is used to create individual nodes within the document itself.

The `Document` class is use to generate the doctype declaration and root level element.

## Installation

{how does one install the product}

## Usage

```php
use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;

Document::create('root',
  Element::create('child',
  	Element::create('grandchild', 'Xavier')->omitEndTag()->props("name Xavier"),
  	'<!CDATA[Hello, my name is Xavier!]]>'
  )
)->build()

// outputs:
// <?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
// <root><child><grandchild name="Xavier"/><!CDATA[Hello, my name is Xavier!]]></child></root>
//
// output (formatted):
// <?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
// <root>
//   <child>
//     <grandchild name="Xavier"/>
//     <!CDATA[Hello, my name is Xavier!]]>
//   </child>
// </root>
```

## Details

This library primarily came about from an experiment in which PHP was viewed
without the additional capability of being a template engine. No need to parse a
string to generate a complete string and future response.

The secondary pain point was to keep the feel of writing human-friendly XML
(tabs and spaces) while reducing the potential for human error; specifically,
mismatched beginning and ending tags.

Finally, working with PHP:DOM and SimpleXML felt quite painful when generating
or maniulating HTML and XML documents rather than parsing a string or file
contents.

## Other

{links or descriptions or license, versioning, and governance}
