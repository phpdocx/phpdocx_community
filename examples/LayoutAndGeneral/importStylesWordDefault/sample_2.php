<?php
// import specific MS Word default styles and use them to add a new content

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$docx->importStylesWordDefault('ignore', array('Heading1', 'Heading2', 'Heading3'));

$docx->addText('Heading 1.', array('pStyle' => 'Heading1'));
$docx->addText('Heading 2.', array('pStyle' => 'Heading2'));
$docx->addText('Heading 3.', array('pStyle' => 'Heading3'));

$docx->createDocx(__DIR__ . '/example_importStylesWordDefault_2');