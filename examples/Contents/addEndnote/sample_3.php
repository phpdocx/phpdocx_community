<?php
// add an endnote using WordFragments

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$textDocumentFragment = new Phpdocx\Elements\WordFragment($docx, 'endnote');
$textDocumentFragment->addText('custom endnote', array('bold' => true, 'fontSize' => 14));
$textEndnoteFragment = new Phpdocx\Elements\WordFragment($docx, 'endnote');
$textEndnoteFragment->addText('The endnote we want to insert.', array('bold' => true));

$endnote = new Phpdocx\Elements\WordFragment($docx, 'document');
$endnote->addEndnote(
    array(
        'textDocument' => $textDocumentFragment,
        'textEndnote' => $textEndnoteFragment,
    )
);

$text = array();
$text[] = array('text' => 'Here comes the ');
$text[] = $endnote;
$text[] = array('text' => ' and some other text.');

$docx->addText($text);
$docx->addText('Some other text.');

$docx->createDocx(__DIR__ . '/example_addEndnote_3');