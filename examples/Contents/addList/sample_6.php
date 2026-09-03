<?php
// add a list using a custom number ID to continue a previous list

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$itemList = array(
    'Line 1',
    'Line 2',
    'Line 3',
    'Line 4',
    'Line 5'
);

$docx->addList($itemList, 2);

$docx->addText('Some content.');

$itemList = array(
    'Line 1',
    'Line 2',
    'Line 3',
    'Line 4',
    'Line 5'
);

// CreateDocx::$numOL returns the numId of the previous list generated with addList
$docx->addList($itemList, 2, array('numId' => Phpdocx\Create\CreateDocx::$numOL));

$docx->createDocx(__DIR__ . '/example_addList_6');