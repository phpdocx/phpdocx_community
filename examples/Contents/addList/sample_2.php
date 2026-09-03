<?php
// add a list with subitems

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$itemList = array(
    'Line 1',
    array(
        'Line A',
        'Line B',
        'Line C'
    ),
    'Line 2',
    'Line 3',
);

// set the style type to 2: ordered list
$docx->addList($itemList, 2);

$docx->createDocx(__DIR__ . '/example_addList_2');