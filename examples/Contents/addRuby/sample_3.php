<?php
// add a ruby content applying styles using WordFragments

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$textFragment = new Phpdocx\Elements\WordFragment($docx);
$textFragment->addText('A ruby content: ');
$rubyFragment1 = new Phpdocx\Elements\WordFragment($docx);
$rubyFragment1->addRuby(array('rt' => 'Kan', 'rubyBase' => array('text' => '漢')));
$rubyFragment2 = new Phpdocx\Elements\WordFragment($docx);
$rubyFragment2->addRuby(array('rt' => 'ji', 'rubyBase' => array('text' => '字')));

$text = array(
    $textFragment,
    $rubyFragment1,
    $rubyFragment2,
);
$docx->addText($text);

$docx->createDocx(__DIR__ . '/example_addRuby_3');