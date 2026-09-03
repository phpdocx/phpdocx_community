<?php
// add a page number to the default footer applying a custom style and setting page-of type

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$style = array(
    'bold' => true,
    'color' => 'B70000',
    'fontSize' => 30,
);

// create a custom style
$docx->createParagraphStyle('pgStyle', $style);

// create a Word fragment to insert in the footer
$numbering = new Phpdocx\Elements\WordFragment($docx, 'defaultFooter');
// set some formatting options
$options = array(
    'textAlign' => 'right',
    'pStyle' => 'pgStyle',
);
$numbering->addPageNumber('page-of', $options);

$docx->addFooter(array('default' => $numbering));

// include some pages to better illustrate the example
$docx->addText('This is the first page.');
$docx->addBreak(array('type' => 'page'));
$docx->addText('This is the second page.');
$docx->addBreak(array('type' => 'page'));
$docx->addText('This is the third page.');
$docx->addBreak(array('type' => 'page'));
$docx->addText('This is the fourth page.');

$docx->createDocx(__DIR__ . '/example_addPageNumber_2');