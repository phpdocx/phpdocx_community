<?php
// import all MS Word default styles and use them to add a new content

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$docx->importStylesWordDefault();

$docx->addText('This is the resulting paragraph with the default "Heading1" style.', array('pStyle' => 'Heading1'));

$valuesTable = array(
    array(11, 12, 13, 14),
    array(21, 22, 23, 24),
    array(31, 32, 33, 34),
);
$paramsTable = array(
    'tableStyle' => 'TableGrid',
);
$docx->addTable($valuesTable, $paramsTable);

$docx->createDocx(__DIR__ . '/example_importStylesWordDefault_1');