# phpdocx Community Edition

[phpdocx](https://www.phpdocx.com) is a PHP library designed to dynamically generate documents in Word format (WordprocessingML).

**phpdocx Community Edition** is a free, reduced version of the full [phpdocx](https://www.phpdocx.com) library. It includes a limited subset of the features available in the commercial editions.

The commercial editions provide a much broader feature set, including support for templates, HTML content, blocks, charts, headers, footers, PDF, watermarks, merging, conversion plugin, encryption, digital signatures, JavaScript API, JSON API, and improved performance, together with technical support. Visit the [phpdocx site](https://www.phpdocx.com) for the full feature list and available licenses.

## Requirements

- PHP >= 5.6
- `ext-dom`
- `ext-xml`
- `ext-exif`
- `ext-gd`
- `ext-mbstring`
- `ext-zip`

## Installation

### Install with Composer

```sh
composer require phpdocx/phpdocx_community
```

### Download and install

Download the project files and include the bundled autoloader in your PHP script:

```php
<?php
require_once __DIR__ . '/Classes/Phpdocx/Create/CreateDocx.php';
```

This loads the library classes automatically so you can use the phpdocx classes in your project.

## Examples

The examples folder contains self-contained samples for all the public methods.

For example, to create a DOCX file containing text with some styles:

```php
$docx = new Phpdocx\Create\CreateDocx();

$text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';

$paragraphOptions = array(
    'bold' => true,
    'font' => 'Arial',
);

$docx->addText($text, $paragraphOptions);

$docx->createDocx('output');
```

## Changelog

See CHANGELOG.md for release notes.

## License

This project is distributed under the terms described in the LICENSE file.