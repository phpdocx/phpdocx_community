<?php
// add ruby contents

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$docx->addRuby(array('rt' => 'Ashita', 'rubyBase' => array('text' => '明日')));

$docx->addRuby(array('rt' => 'さくら', 'rubyBase' => array('text' => '桜')));

$docx->createDocx(__DIR__ . '/example_addRuby_1');