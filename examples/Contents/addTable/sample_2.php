<?php
// add a table that includes WordFragments

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

// create a few Word fragments to insert rich content in a table

$link = new Phpdocx\Elements\WordFragment($docx);
$options = array(
    'url' => 'http://www.google.com'
);

$link->addLink('Link to Google', $options);

$image = new Phpdocx\Elements\WordFragment($docx);
$options = array(
    'src' => __DIR__ . '/../../files/image.png'
);

$image->addImage($options);

$text = new Phpdocx\Elements\WordFragment($docx);
$text->addText("Line A\nand more content", array('parseLineBreaks' => true));

$valuesTable = array(
    array(
        'Title A',
        'Title B',
        'Title C'
    ),
    array(
        $text,
        $link,
        $image
    )
);

$paramsTable = array(
    'tableStyle' => 'LightListAccent1PHPDOCX',
    'tableAlign' => 'center',
    'columnWidths' => array(1000, 2500, 5000),
);

$docx->addTable($valuesTable, $paramsTable);

$docx->createDocx(__DIR__ . '/example_addTable_2');