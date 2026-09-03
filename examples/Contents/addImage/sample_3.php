<?php
// add an image with an URL

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$options = array(
    'src' => __DIR__ . '/../../files/image.png',
    'scaling' => 50,
    'spacingTop' => 10,
    'spacingBottom' => 0,
    'spacingLeft' => 0,
    'spacingRight' => 20,
    'hyperlink' => 'http://www.google.com',
);

$docx->addImage($options);

$docx->createDocx(__DIR__ . '/example_addImage_3');