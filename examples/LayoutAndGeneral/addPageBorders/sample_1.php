<?php
// add page borders

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$options = array(
	'borderWidth' => 12,
	'borderTopColor' => 'FF0000',
);
$docx->addPageBorders($options);
$text = 'This is just a chunk of text that we will repeat couple of times to fill up some space. ';
$text .= $text;
$docx->addText($text);
$docx->addText('Another chunk of text');
$docx->addText($text);

$docx->createDocx(__DIR__ . '/example_addPageBorders_1');