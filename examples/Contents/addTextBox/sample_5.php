<?php
// add textboxes applying rotations

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

// default rotation
$text = 'Some text content for the textbox 1.';
$textBoxOptions = array(
    'align' => 'inline',
    'paddingLeft' => 10,
    'borderColor' => '#b70000',
    'borderWidth' => 4,
    'fillColor' => '#dddddd',
    'width' => 240,
);
$docx->addTextBox($text, $textBoxOptions);

// 90º rotation
$text = 'Some text content for the textbox 2.';
$textBoxOptions = array(
    'align' => 'inline',
    'borderColor' => '#b70000',
    'borderWidth' => 4,
    'fillColor' => '#dddddd',
    'width' => 240,
    'textboxStyle' => 'layout-flow:vertical',
);
$docx->addTextBox($text, $textBoxOptions);

// 270º rotation
$text = 'Some text content for the textbox 3.';
$textBoxOptions = array(
    'align' => 'inline',
    'borderColor' => '#b70000',
    'borderWidth' => 4,
    'fillColor' => '#dddddd',
    'width' => 240,
    'textboxStyle' => 'layout-flow:vertical;mso-layout-flow-alt:bottom-to-top',
);
$docx->addTextBox($text, $textBoxOptions);

$docx->createDocx(__DIR__ . '/example_addTextBox_5');