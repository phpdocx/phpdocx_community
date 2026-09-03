<?php
// add structured document tags

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

// Combo box
$list = array(
	array('First Choice', 1),
	array('second choice', 2),
	array('Third choice', 3),
);
$options = array(
	'listItems' => $list,
	'placeholderText' => 'Choose a value or write it down',
	'alias' => 'Combo Box',
	'fontSize' => 12,
	'italic' => true,
	'color' => 'FF0000',
	'bold' => true,
	'underline' => 'single',
	'font' => 'Algerian'
);
$docx->addStructuredDocumentTag('comboBox', $options );

// date
$options = array(
	'placeholderText' => 'Choose a date',
	'alias' => 'Date picker',
	'fontSize' => 14,
	'italic' => true,
	'color' => '777777',
	'bold' => true,
	'font' => 'Calibri'
);
$docx->addStructuredDocumentTag('date', $options);

// dropdown
$list = array(
	array('One', 1),
	array('Two', 2),
	array('Three', 3)
);
$options = array(
	'listItems' => $list,
	'placeholderText' => 'Choose a value',
	'alias' => 'Dropdown menu',
	'fontSize' => 12
);
$docx->addStructuredDocumentTag('comboBox', $options);

// richText
$options = array(
	'placeholderText' => 'This text is locked',
	'alias' => 'Rich text',
	'lock' => 'contentLocked'
);
$docx->addStructuredDocumentTag('richText', $options);

// richText with text content and line breaks
$options = array(
	'text' => "Rich text content 2\nMore content",
	'parseLineBreaks' => true,
	'bold' => true,
);
$docx->addStructuredDocumentTag('richText', $options);

// text
$options = array(
	'text' => 'Text sdt',
);
$docx->addStructuredDocumentTag('text', $options);

// WordFragment added as text content
$contentFragment = new Phpdocx\Elements\WordFragment($docx);
$contentFragment->addText('Text content');
$contentFragment->addTable(array(
	array(11, 12, 13, 14),
	array(21, 22, 23, 24),
	array(31, 32, 33, 34),
));
$options = array(
	'wordFragment' => $contentFragment,
);
$docx->addStructuredDocumentTag('richText', $options);

// checkboxes with custom styles
$docx->addStructuredDocumentTag('checkbox', array('fontSize' => 18, 'checked' => true));
$docx->addStructuredDocumentTag('checkbox', array('fontSize' => 18, 'checked' => true, 'highlightColor' => 'red'));
// checkbox with custom styles and custom symbol
$docx->addStructuredDocumentTag('checkbox', array('fontSize' => 18, 'checked' => true, 'checkedState' => array('font' => 'Wingdings', 'value' => '00FE'), 'uncheckedState' => array('font' => 'Wingdings', 'value' => '006F'), 'sym' => array('char' => '00FE', 'font' => 'Wingdings')));

// checkbox added as WordFragment
$checkboxFragment = new Phpdocx\Elements\WordFragment($docx, 'document');
$checkboxFragment->addStructuredDocumentTag('checkbox', ['fontSize' => 11, 'checked' => true]);
$docx->addText([array('text' => 'Checkbox: ', 'fontSize' => 12), $checkboxFragment]);

// sdtContent added as internal content in a structured document tag. WordFragments must be used
$contentFragment = new Phpdocx\Elements\WordFragment($docx);
$contentFragment->addText('Text content');
$contentFragment->addTable(array(
	array(11, 12, 13, 14),
	array(21, 22, 23, 24),
	array(31, 32, 33, 34),
));

$structuredDocumentTagFragment = new Phpdocx\Elements\WordFragment($docx);
$options = array(
	'wordFragment' => $contentFragment,
);
$structuredDocumentTagFragment->addStructuredDocumentTag('sdtContent', $options);

$options = array(
	'wordFragment' => $structuredDocumentTagFragment,
);
$docx->addStructuredDocumentTag('sdtContent', $options);

// repeating section. Compatible from MS Word 2013
$contentFragment = new Phpdocx\Elements\WordFragment($docx);
$contentFragment->addText('Text content');
$contentFragment->addTable(array(
	array(11, 12, 13, 14),
	array(21, 22, 23, 24),
	array(31, 32, 33, 34),
));

$structuredDocumentTagFragment = new Phpdocx\Elements\WordFragment($docx);
$options = array(
	'wordFragment' => $contentFragment,
    'repeatingSectionItem' => true
);
$structuredDocumentTagFragment->addStructuredDocumentTag('sdtContent', $options);

$options = array(
	'wordFragment' => $structuredDocumentTagFragment,
    'repeatingSection' => true
);
$docx->addStructuredDocumentTag('sdtContent', $options);

$docx->createDocx(__DIR__ . '/example_addStructuredDocumentTag_1');