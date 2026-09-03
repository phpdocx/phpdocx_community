<?php
// add an image using relative positions

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$docx->addText('Image with relativeToHorizontal and relativeToVertical values.');

$options = array(
    'src' => __DIR__ . '/../../files/image.png',
    'scaling' => 50,
    'relativeToHorizontal' => 'page',
    'relativeToVertical' => 'page',
    'textWrap' => 2,
    'float' => 'right',
    'verticalAlign' => 'top',
);

$docx->addImage($options);

$docx->createDocx(__DIR__ . '/example_addImage_5');