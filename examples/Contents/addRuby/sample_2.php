<?php
// add a ruby content applying styles

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$paragraphOptions = array(
    'rubyAlign' => 'right',
    'hps' => 16,
    'hpsRaise' => 40,
    'hpsBaseText' => 32,
    'bold' => true,
    'font' => 'Arial',
    'fontSize' => 16,
);
$docx->addRuby(array('rt' => 'Ashita', 'rubyBase' => array('text' => '明日', 'bold' => true, 'italic' => true)), $paragraphOptions);

$docx->createDocx(__DIR__ . '/example_addRuby_2');