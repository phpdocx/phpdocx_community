<?php
// add a WordFragment to the end of the document. DOCXPath available in Advanced and Premium licenses allows inserting WordFragments to any position

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$wordFragment = new Phpdocx\Elements\WordFragment($docx);

// a WordFragment may include one or more contents

$imageOptions = array(
    'src' => __DIR__ . '/../../files/image.png',
    'scaling' => 50,
    'float' => 'right',
    'textWrap' => 1,
);
$wordFragment->addImage($imageOptions);

$linkOptions = array(
    'url' => 'http://www.google.com',
    'color' => '0000FF',
    'underline' => 'single',
);
$wordFragment->addLink('link to Google', $linkOptions);

$docx->addWordFragment($wordFragment);

$docx->createDocx(__DIR__ . '/example_addWordFragment_1');