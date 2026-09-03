<?php
// add a text applying styles to run of text contents

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

// a paragraph composed of two runs of text with different properties
$text = array();
$text[] =
    array(
        'text' => 'We know this looks ugly',
        'underline' => 'single'
);
$text[] =
    array(
        'text' => ' but we only want to illustrate some of the functionality of the addText method.',
        'bold' => true
);
// add some borders to the paragraph to illustrate that functionality
$paragraphOptions = array(
    'border' => 'double',
    'borderColor' => 'b70000',
    'borderWidth' => 12,
    'borderSpacing' => 8,
    'borderTopColor' => '000000',
);
$docx->addText($text, $paragraphOptions);

$docx->createDocx(__DIR__ . '/example_addText_2');