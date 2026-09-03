<?php
// add date properties

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, ' .
    'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut ' .
    'enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut' .
    'aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit ' .
    'in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ' .
    'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui ' .
    'officia deserunt mollit anim id est laborum.';

$paramsText = array(
    'bold' => true,
    'font' => 'Arial'
);

$docx->addText($text, $paramsText);

$properties = array(
    'created' => '2016-11-21T09:00:00Z', // force a value
    'modified' => substr(date(DATE_W3C), 0, 19) . 'Z', // dynamic value
    'lastModifiedBy' => 'phpdocxuser',
);
$docx->addProperties($properties);

$docx->createDocx(__DIR__ . '/example_addProperties_2');