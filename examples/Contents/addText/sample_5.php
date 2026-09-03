<?php
// create custom styles to add new contents

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

// style options
$style = array(
    'color'            => '999999',
    'border'           => 'single',
    'borderColor'      => '990000',
    'borderRightColor' => '000099',
    'borderWidth'      => 12,
    'borderTopWidth'   => 24,
);
// create custom paragraph style
$docx->createParagraphStyle('mypStyle', $style);

$style = array(
    'bold' => true,
    'color' => 'ff0000',
    'font' => 'Arial',
    'fontSize' => 18,
    'italic' => true,
    'position' => 6,
    'underline' => 'single',
);
// create custom character style
$docx->createCharacterStyle('mycStyle', $style);

$text = array();
$text[] =
    array(
        'text' => 'Text MyStyle',
        'rStyle' => 'mycStyle'
);
$text[] =
    array(
        'text' => ' text MyStyle2.',
);

$docx->addText($text, array('pStyle' => 'mypStyle'));

$docx->createDocx(__DIR__ . '/example_addText_5');