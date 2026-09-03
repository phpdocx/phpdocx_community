<?php
// add drop caps with text

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

// text without drop cap
$docx->addText($text);

// drop cap with default options
$docx->addDropCap('L');
$docx->addText(substr($text, 1));

// drop cap with custom options
$docx->addDropCap('L', array(), array('framePr' => array('hSpace' => 400)));
$docx->addText(substr($text, 1), array('textAlign' => 'both'));

// drop cap with custom options
$docx->addDropCap('L', array('italic' => true, 'bold' => true, 'fontSize' => 100), array('framePr' => array('dropCap' => 'margin', 'hAnchor' => 'page', 'hSpace' => 400, 'lines' => 5)));
$docx->addText(substr($text, 1), array('textAlign' => 'both'));

$docx->createDocx(__DIR__ . '/example_addDropCap_1');