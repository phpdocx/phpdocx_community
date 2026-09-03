<?php
// add a footnote using WordFragments

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$textDocumentFragment = new Phpdocx\Elements\WordFragment($docx, 'footnote');
$textDocumentFragment->addText('custom footnote', array('bold' => true, 'fontSize' => 14));
$textFootnoteFragment = new Phpdocx\Elements\WordFragment($docx, 'footnote');
$textFootnoteFragment->addText('The footnote we want to insert.', array('bold' => true));

$footnote = new Phpdocx\Elements\WordFragment($docx, 'document');
$footnote->addFootnote(
    array(
        'textDocument' => $textDocumentFragment,
        'textFootnote' => $textFootnoteFragment,
    )
);

$text = array();
$text[] = array('text' => 'Here comes the ');
$text[] = $footnote;
$text[] = array('text' => ' and some other text.');

$docx->addText($text);
$docx->addText('Some other text.');

$docx->createDocx(__DIR__ . '/example_addFootnote_3');