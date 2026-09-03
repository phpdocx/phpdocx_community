<?php
// add links

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$docx->addLink('Link to Google', array('url'=> 'http://www.google.com'));

$docx->addText('And now the same link with some additional formatting:');

$linkOptions = array(
    'url'=> 'http://www.google.com',
    'color' => 'B70000',
    'underline' => 'none',
);
$docx->addLink('Link to Google in red color and not underlined', $linkOptions);

$docx->createDocx(__DIR__ . '/example_addLink_1');