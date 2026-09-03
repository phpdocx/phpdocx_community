<?php
// add textboxes using absolute positions and WordFragments

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$text = 'Some text content for the textbox 1.';

$textBoxOptions = array(
    'align' => 'absolute',
    'position' => 'absolute',
    'paddingLeft' => 5,
    'border' => false,
    'fillColor' => '#ddddff',
    'width' => 200,
    'marginTop' => 1,
    'marginLeft' => 1,
    'z-index' => 10,
    'relativeToHorizontal' => 'page',
    'relativeToVertical' => 'page',
);
$docx->addTextBox($text, $textBoxOptions);

$text = 'Some text content for the textbox 2.';

$textBoxOptions = array(
    'align' => 'absolute',
    'position' => 'absolute',
    'paddingLeft' => 5,
    'border' => false,
    'fillColor' => '#ddddff',
    'width' => 100,
    'height' => 300,
    'marginTop' => 10,
    'marginLeft' => 3,
    'z-index' => 10,
    'relativeToHorizontal' => 'page',
    'relativeToVertical' => 'page',
);

$docx->addTextBox($text, $textBoxOptions);

$textFragment = new Phpdocx\Elements\WordFragment($docx);
$paragraphOptions = array(
    'bold' => true,
    'font' => 'Arial',
    'fontSize' => 20,
);
$textFragment->addText('Some text content for the textbox 3.', $paragraphOptions);

$textBoxOptions = array(
    'align' => 'absolute',
    'position' => 'absolute',
    'paddingLeft' => 5,
    'border' => false,
    'fillColor' => '#ff0000',
    'width' => 100,
    'height' => 300,
    'marginTop' => 10,
    'marginLeft' => 7.2,
    'z-index' => 15,
    'relativeToHorizontal' => 'page',
    'relativeToVertical' => 'page',
);

$docx->addTextBox($textFragment, $textBoxOptions);

$docx->createDocx(__DIR__ . '/example_addTextBox_4');