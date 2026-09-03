<?php
// add a TOC applying custom styles

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$docx->addText('Table of Contents', array('bold' => true, 'fontSize' => 14));
$legend = array(
    'text' => 'Click here to update the TOC',
    'color' => 'B70000',
    'bold' => true,
    'fontSize' => 12,
);
$docx->addTableContents(array('autoUpdate' => true), $legend);

// add some headings so they show up in the TOC
$docx->addText('Chapter 1', array('pStyle' => 'Heading1PHPDOCX'));
$docx->addText('Section', array('pStyle' => 'Heading2PHPDOCX'));
$docx->addText('Another TOC entry', array('pStyle' => 'Heading3PHPDOCX'));

// generate custom paragraph styles for updated TOC contents
$styleToc1 = array(
    'color' => 'B70000',
    'fontSize' => 48,
    'name' => 'toc 1',
);
$styleToc2 = array(
    'color' => 'B70000',
    'fontSize' => 32,
    'name' => 'toc 2',
);
// create custom style
$docx->createParagraphStyle('TOC1', $styleToc1);
$docx->createParagraphStyle('TOC2', $styleToc2);

$docx->createDocx(__DIR__ . '/example_addTableContents_3');