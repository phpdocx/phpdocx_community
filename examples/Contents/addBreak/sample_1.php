<?php
// add line and page breaks

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, ' .
    'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut ' .
    'enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut' .
    'aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit ' .
    'in voluptate velit esse cillum dolore eu fugiat nulla pariatur.';

$docx->addText($text);

$docx->addText($text);

$docx->addBreak(array('type' => 'line'));
// the break is added in a new paragraph, so two breaks are done (paragraph and line).
// An empty text can be added to generate a single break
// $docx->addText('');

$docx->addText($text);

$docx->addBreak(array('type' => 'line', 'number' => 2));

$docx->addText($text);

$docx->addBreak(array('type' => 'page'));

$docx->addText($text);

$docx->createDocx(__DIR__ . '/example_addBreak_1');