<?php
// set background color

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

// set the background color of the document
$docx->setBackgroundColor('FFFFCC');
// include a paragraph of plain text
$docx->addText('This document should have a pale yellow background color.');

$docx->createDocx(__DIR__ . '/example_setBackgroundColor_1');