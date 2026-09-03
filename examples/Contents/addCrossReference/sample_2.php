<?php
// add cross-references to bookmarks setting the references as ABOVE_BELOW and REF

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$docx->addText('Text that has not been bookmarked.');

$docx->addCrossReference('Cross-reference 1', array('type' => 'bookmark', 'referenceName'=> 'bookmark_name', 'referenceTo' => 'ABOVE_BELOW'));

$docx->addBookmark(array('type' => 'start', 'name' => 'bookmark_name'));
$docx->addText('Text that has been bookmarked.');
$docx->addBookmark(array('type' => 'end', 'name' => 'bookmark_name'));

$docx->addBreak(array('type' => 'page'));

$docx->addCrossReference('Custom text cross-reference', array('type' => 'bookmark', 'referenceName'=> 'bookmark_name', 'referenceTo' => 'REF'));

$docx->addCrossReference('Cross-reference 2', array('type' => 'bookmark', 'referenceName'=> 'bookmark_name', 'referenceTo' => 'ABOVE_BELOW'));

$docx->createDocx(__DIR__ . '/example_addCrossReference_2');