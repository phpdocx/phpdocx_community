<?php
// add an endnote with styles

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$textEndnoteFragment = new Phpdocx\Elements\WordFragment($docx, 'endnote');
$textEndnoteFragment->addText(' The endnote to insert.');

$endnote = new Phpdocx\Elements\WordFragment($docx, 'document');
$endnote->addEndnote(
    array(
        'textDocument' => 'endnote',
        'textEndnote' => $textEndnoteFragment,
        'endnoteMark' => array(
            'bold' => true,
            'color' => 'FF0000',
            'underline' => 'single',
            'fontSize' => 14,
        ),
        'referenceMark' => array(
            'bold' => true,
            'color' => '0000FF',
            'backgroundColor' => 'FFB703',
            'underline' => 'single',
            'fontSize' => 12,
        ),
    )
);

$text = array();
$text[] = array('text' => 'Here comes the ');
$text[] = $endnote;
$text[] = array('text' => ' and some other text.');

$docx->addText($text);
$docx->addText('Some other text.');

// set a new endnote format
$docx->modifyPageLayout('custom', array('endnotes' => array('numFmt' => 'lowerLetter')));

$docx->createDocx(__DIR__ . '/example_addEndnote_4');