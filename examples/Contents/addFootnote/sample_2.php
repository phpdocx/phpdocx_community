<?php
// add multiple footnotes

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$footnote = new Phpdocx\Elements\WordFragment($docx, 'document');

$footnote->addFootnote(
    array(
        'textDocument' => 'footnote',
        'textFootnotes' => array(
            array(
                'textFootnote'=> ' The footnote we want to insert.',
            ),
            array(
                'textFootnote'=> ' The 2nd footnote we want to insert.',
            ),
        )
    )
);

$text = array();
$text[] = array('text' => 'Here comes the ');
$text[] = $footnote;
$text[] = array('text' => ' and some other text.');

$docx->addText($text);
$docx->addText('Some other text.');

$docx->createDocx(__DIR__ . '/example_addFootnote_2');