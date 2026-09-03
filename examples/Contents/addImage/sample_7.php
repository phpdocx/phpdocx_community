<?php
// add an image using an image resource

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$imageResource = imagecreatefromjpeg(__DIR__ . '/../../files/image.jpg');
$options = array(
    'src' => $imageResource,
    'resourceMode' => true,
);

$docx->addImage($options);

$docx->createDocx(__DIR__ . '/example_addImage_7');