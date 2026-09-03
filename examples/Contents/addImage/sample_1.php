<?php
// add an image with a caption

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$docx->addText('In this first example we just add an image with a dashed border:');

$options = array(
    'src' => __DIR__ . '/../../files/image.png',
    'imageAlign' => 'center',
    'scaling' => 50,
    'spacingTop' => 10,
    'spacingBottom' => 0,
    'spacingLeft' => 0,
    'spacingRight' => 20,
    'textWrap' => 0,
    'borderStyle' => 'lgDash',
    'borderWidth' => 6,
    'borderColor' => 'FF0000',
    'caption' => array('showLabel' => true, 'text' => ' Sample Image', 'styleName' => 'Figure', 'bookmarkName' => 'my_bookmark'),
);

$docx->addImage($options);

$docx->addText('This is a closing paragraph.');

$docx->createDocx(__DIR__ . '/example_addImage_1');