<?php
// add tabs in text contents

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

// add a tab using WordFragments
$textFragmentA = new Phpdocx\Elements\WordFragment($docx);
$textFragmentA->addText('Text content using WordFragments:');

$tabFragment = new Phpdocx\Elements\WordFragment($docx);
$tabFragment->addTab();

$textFragmentB = new Phpdocx\Elements\WordFragment($docx);
$textFragmentB->addText('tab content.');

$contents = array();
$contents[] = $textFragmentA;
$contents[] = $tabFragment;
$contents[] = $textFragmentB;

$docx->addText($contents);

// the same can be done using the tab option included in addText
$text = array();
$text[] = array('text' => 'Text content using text array:');
$text[] = array('text' => 'tab content.', 'tab' => true);

$docx->addText($text);

$docx->createDocx(__DIR__ . '/example_addTab_1');