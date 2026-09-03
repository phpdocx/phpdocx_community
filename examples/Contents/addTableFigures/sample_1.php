<?php
// add table of figures

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$docx->addText('Table of Figures', array('bold' => true, 'fontSize' => 14));
$legend = array(
    'text' => 'Click here to update the table of figures',
    'color' => 'B70000',
    'bold' => true,
    'fontSize' => 12,
);
// table of figures to display tables
$docx->addTableFigures(array('autoUpdate' => true, 'scope' => 'Table'), $legend);

$docx->addText('Table of Figures', array('bold' => true, 'fontSize' => 14));
$legend = array(
    'text' => 'Click here to update the table of figures',
    'fontSize' => 11,
);
// table of figures to display figures
$docx->addTableFigures(array('autoUpdate' => true, 'scope' => 'Figure'), $legend);

// add contents to be displayed in table of figures
$valuesTable = array(
    array(
        11,
        12,
        13,
        14
    ),
    array(
        21,
        22,
        23,
        24
    ),
    array(
        31,
        32,
        33,
        34
    ),

);

$paramsTable = array(
    'border' => 'single',
    'tableAlign' => 'center',
    'borderWidth' => 10,
    'borderColor' => 'B70000',
    'textProperties' => array('bold' => true, 'font' => 'Algerian', 'fontSize' => 18),
    'caption' => array('showLabel' => true, 'text' => ' Sample Table', 'align' => 'right', 'styleName' => 'Table'),
);

$docx->addTable($valuesTable, $paramsTable);

$options = array(
    'src' => __DIR__ . '/../../files/image.png',
    'imageAlign' => 'center',
    'scaling' => 50,
    'spacingTop' => 10,
    'spacingBottom' => 0,
    'spacingLeft' => 0,
    'spacingRight' => 20,
    'textWrap' => 0,
    'borderStyle' => 'lgDash',
    'borderWidth' => 6,
    'borderColor' => 'FF0000',
    'caption' => array('showLabel' => false, 'text' => ' Sample Image 1', 'styleName' => 'Figure', 'keepNext' => true, 'position' => 'above'),
);

$docx->addImage($options);

$options = array(
    'src' => __DIR__ . '/../../files/image.png',
    'imageAlign' => 'center',
    'scaling' => 50,
    'spacingTop' => 10,
    'spacingBottom' => 0,
    'spacingLeft' => 0,
    'spacingRight' => 20,
    'textWrap' => 0,
    'borderStyle' => 'lgDash',
    'borderWidth' => 6,
    'borderColor' => 'FF0000',
    'caption' => array('showLabel' => false, 'text' => ' Sample Image 2', 'styleName' => 'Figure'),
);

$docx->addImage($options);

$docx->createDocx(__DIR__ . '/example_addTableFigures_1');