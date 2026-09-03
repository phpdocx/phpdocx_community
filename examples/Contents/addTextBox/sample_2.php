<?php
// add textboxes applying styles using WordFragments

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$txtbx = new Phpdocx\Elements\WordFragment($docx);

$text = 'Some text content for the textbox. Lorem ipsum dolor sit amet, consectetur adipisicing elit, ' .
    'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut ' .
    'enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut' .
    'aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit ' .
    'in voluptate velit esse cillum dolore eu fugiat nulla pariatur.';

$textBoxOptions = array(
    'align' => 'right',
    'paddingLeft' => 5,
    'border' => false,
    'fillColor' => '#ddddff',
    'width' => 200,
    'marginTop' => 10,
);

$txtbx->addTextBox($text, $textBoxOptions);

$documentText = 'Text in the main document flow. Lorem ipsum dolor sit amet, consectetur adipisicing elit, ' .
    'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut ' .
    'enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut' .
    'aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit ' .
    'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut ' .
    'enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut' .
    'aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit ' .
    'in voluptate velit esse cillum dolore eu fugiat nulla pariatur.';


$textRuns = array();

$textRuns[] = $txtbx;
$textRuns[] = array('text' => $documentText);

$docx->addText($textRuns);

$docx->createDocx(__DIR__ . '/example_addTextBox_2');