<?php
// add multiple endnotes

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$endnote = new Phpdocx\Elements\WordFragment($docx, 'document');

$endnote->addEndnote(
    array(
        'textDocument' => 'endnote',
        'textEndnotes' => array(
            array(
                'textEndnote' => ' The endnote we want to insert.',
            ),
            array(
                'textEndnote' => ' The 2nd endnote we want to insert.',
            )
        ),
    )
);

$text = array();
$text[] = array('text' => 'Here comes the ');
$text[] = $endnote;
$text[] = array('text' => ' and some other text.');

$docx->addText($text);

$docx->addText('Some other text.');

$docx->createDocx(__DIR__ . '/example_addEndnote_2');