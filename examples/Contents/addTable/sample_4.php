<?php
// add a table that includes WordFragments

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, ' .
    'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut ' .
    'enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut' .
    'aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit ' .
    'in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ' .
    'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui ' .
    'officia deserunt mollit anim id est laborum.';

$paragraphOptions = array(
    'font' => 'Arial'
);

$docx->addText($text, $paragraphOptions);

$footnote = new Phpdocx\Elements\WordFragment($docx, 'document');
$footnote->addFootnote(
  array(
    'textDocument' => 'footnote',
    'textFootnote' => 'The footnote we want to insert.',
    'referenceMark' => array('bold' => true),
  )
);

$textFragment = new Phpdocx\Elements\WordFragment($docx, 'document');

$text = array();
$text[] = array('text' => 'Other text ');
$text[] = $footnote;

$paragraphOptions = array(
  'textAlign' => 'center',
  'bold' => true,
);
$textFragment->addText($text, $paragraphOptions);

$valuesTable = array(
  array(
    $textFragment,
  ),
  array(
    '2',
  ),
);

$docx->addTable($valuesTable);

$docx->createDocx(__DIR__ . '/example_addTable_4');