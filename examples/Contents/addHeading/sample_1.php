<?php
// add headings, addText can also be used to get the same output
// read https://www.phpdocx.com/documentation/cookbook/working-with-headings for more information about working with headings

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$docx->addHeading('First level title', 0);

$text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, ' .
    'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
$docx->addText($text);

$docx->addHeading('Second level title', 1);
$docx->addText($text);

$options = array(
    'color' => 'FF0000',
    'textAlign' => 'center',
    'fontSize' => 13
);

$docx->addHeading('Third level title with additional custom formatting', 2, $options);
$docx->addText($text);

$docx->createDocx(__DIR__ . '/example_addHeading_1');