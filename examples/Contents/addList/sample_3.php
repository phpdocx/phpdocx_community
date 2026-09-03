<?php
// add a list with subitems and WordFragments

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

// prepare some formatted text for insertion in the list
$textData = new Phpdocx\Elements\WordFragment($docx);
$text = array();
$text[] = array('text' => 'We insert some ');
$text[] = array('text' => 'bold text', 'bold' => true);
$textData->addText($text);

$itemList= array(
    'In this example we use a custom list (val = 5) that comes bundled with the default PHPdocX template.',
    array(
        $textData,
        'Line B',
        'Line C'
    ),
    'Line',
);

// set the style type to 5: other predefined Word list style
$docx->addList($itemList, 5);

$docx->createDocx(__DIR__ . '/example_addList_3');