<?php
// set DOCX compatility mode setting

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$text = 'A DOCX with a custom compatibility mode setting.';
$docx->addText($text);

$docx->setCompatibilityMode('15');

$docx->createDocx('example_setCompatibilityMode_1');