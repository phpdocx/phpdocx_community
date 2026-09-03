<?php
// change DOCX settings to set the compatibility mode

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$text = 'Change compatibilityMode and overrideTableStyleFontSizeAndJustification tags';
$docx->addText($text);

$settings = array(
    'compat' => array(
        'compatibilityMode' => array('val' => '15'),
        'overrideTableStyleFontSizeAndJustification' => array('val' => '1'),
    )
);
$docx->docxSettings($settings);

$docx->createDocx(__DIR__ . '/example_docxSettings_3');