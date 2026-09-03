<?php
// add a new section with custom columns

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, ' .
    'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut ' .
    'enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut' .
    'aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit ' .
    'in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ' .
    'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui ' .
    'officia deserunt mollit anim id est laborum.';

$docx->addText($text);

$paramsText = array(
    'bold' => true
);

$docx->addText($text, $paramsText);

$docx->addSection('nextPage', 'A4', array('numberCols' => 3, 'space' => 150));

$docx->addText($text);
$docx->addText($text);
$docx->addText($text);
$docx->addText($text);

$paramsText = array(
    'bold' => true
);

$docx->addText($text, $paramsText);
$docx->addText($text, $paramsText);

$columns = array(
    array(
        'width' => 5760,
        'space' => 720,
    ),
    array(
        'width' => 2880,
    ),
);
$docx->addSection('nextPage', 'A4', array('numberCols' => 2, 'space' => 720, 'columns' => $columns, 'sepCols' => true));

$docx->addText($text);
$docx->addText($text);
$docx->addText($text);
$docx->addText($text);
$docx->addText($text);
$docx->addText($text);
$docx->addText($text);
$docx->addText($text);

$docx->createDocx(__DIR__ . '/example_addSection_3');