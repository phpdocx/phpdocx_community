<?php
// add an image using a stream source

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$options = array(
    'src' => 'https://www.phpdocx.com/img/logo_badge.png',
    'imageAlign' => 'center',
    'streamMode' => true,
);

$docx->addImage($options);

$docx->createDocx(__DIR__ . '/example_addImage_4');