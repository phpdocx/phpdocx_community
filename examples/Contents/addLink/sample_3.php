<?php
// add link to bookmark

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$docx->addBookmark(array('type' => 'start', 'name' => 'bookmark_name'));
$docx->addText('Text that has been bookmarked.');
$docx->addBookmark(array('type' => 'end', 'name' => 'bookmark_name'));

$docx->addBreak(array('type' => 'page'));

$docx->addLink('Link to bookmark', array('url' => '#bookmark_name'));

$docx->createDocx(__DIR__ . '/example_addLink_3');