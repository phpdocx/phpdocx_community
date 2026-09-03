<?php
// add simple field values

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

// add certain properties to the Word document
$properties = array(
    'title' => 'The title of the document.',
    'creator' => 'The author of the document.',
    'description' => 'A description of the document.',
);

$docx->addProperties($properties);

$docx->addText('We add a few simple fields that render the above properties:');

$options = array(
    'pStyle' => 'Heading1PHPDOCX',
);

$docx->addSimpleField('TITLE','','', $options);

$docx->addSimpleField('AUTHOR');
$docx->addSimpleField('NUMPAGES');
$docx->addSimpleField('COMMENTS');

// prompt the user to update the fields on opening
$docx->docxSettings(array('updateFields'=>'true'));

$docx->createDocx(__DIR__ . '/example_addSimpleField_1');