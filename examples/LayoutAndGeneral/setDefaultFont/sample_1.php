<?php
// set the default font

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

// set the default font for the document
$docx->setDefaultFont('Arial Narrow');

// include some paragraphs of plain text
$docx->addText('This text is going to show in Arial Narrow font because it is the chosen default font.');
$docx->addText('The standard default font is usually Calibri.');

$docx->createDocx(__DIR__ . '/example_setDefaultFont_1');