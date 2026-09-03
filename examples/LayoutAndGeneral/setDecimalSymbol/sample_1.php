<?php
// set the decimal symbol

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

// set the decimal symbol for the document
$docx->setDecimalSymbol(',');

$docx->createDocx(__DIR__ . '/example_setDecimalSymbol_1');