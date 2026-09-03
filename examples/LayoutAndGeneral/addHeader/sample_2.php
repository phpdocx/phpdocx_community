<?php
// add default, first and even headers

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

// create a Word fragment with an image to be inserted in the header of the document
$imageOptions = array(
    'src' => __DIR__ . '/../../files/image.png',
    'dpi' => 300,
);

$default = new Phpdocx\Elements\WordFragment($docx, 'defaultHeader');
$default->addImage($imageOptions);
$first = new Phpdocx\Elements\WordFragment($docx, 'firstHeader');
$first->addText('first page header.');
$even = new Phpdocx\Elements\WordFragment($docx, 'evenHeader');
$even->addText('even page header.');

$docx->addHeader(array('default' => $default, 'first' => $first, 'even' => $even));

// add some text
$docx->addText('This is the first page of a document with different headers for the first and even pages.');
$docx->addBreak(array('type' => 'page'));
$docx->addText('This is the second page.');
$docx->addBreak(array('type' => 'page'));
$docx->addText('This is the third page.');

$docx->createDocx(__DIR__ . '/example_addHeader_2');