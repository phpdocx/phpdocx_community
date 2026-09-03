<?php
// add a link as a WordFragment

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$link = new Phpdocx\Elements\WordFragment($docx);
$link->addLink('Google', array('url'=> 'http://www.google.com'));

$runs = array();
$runs[] = array('text' => 'Now we include a link to ');
$runs[] = $link;
$runs[] = array('text' => ' in the middle of a paragraph of plain text.');

$docx->addText($runs);

$docx->createDocx(__DIR__ . '/example_addLink_2');