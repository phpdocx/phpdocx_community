<?php
// add shapes with text contents

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$txtboxContent = new Phpdocx\Elements\WordFragment($docx);

$runs = array();

$runs[] = array('text' => 'This text is normal.');
$runs[] = array('text' => ' And this text is red.', 'color' => 'FF0000');

$txtboxContent->addText($runs);

$docx->addText('Curve:');

$options = array(
	'from' => '300,40',
	'to' => '120,150',
	'fillcolor' => '#555555',
	'strokecolor' => '#ff0000',
	'strokeweight' => '4',
	'control1' => '60,70',
	'control2' => '125,170',
	'textContent' => $txtboxContent,
);
$docx->addShape('curve', $options);

$docx->addBreak();

$docx->addText('Line:');

$options = array(
	'from' => '10,10',
	'to' => '150,10',
	'strokecolor' => '#0000ff',
	'strokeweight' => '2',
	'position' => 'absolute',
	'margin-left' => 20,
	'textContent' => $txtboxContent,
);
$docx->addShape('line', $options);

$docx->addBreak();

$docx->addText('Rectangle:');

$options = array(
	'width' => 60,
	'height' => 60,
	'strokecolor' => '#ff00ff',
	'strokeweight' => '3',
	'fillcolor' => '#ffff00',
	'position' => 'absolute',
	'marginLeft' => 10,
	'marginTop' => -5,
	'textContent' => $txtboxContent,
);

$docx->addShape('rect', $options);

$docx->addBreak(array('type' => 'line', 'number' => 5));

$docx->addText('Oval:');

$options = array(
	'width' => 100,
	'height' => 100,
	'strokecolor' => '#000000',
	'strokeweight' => '2',
	'fillcolor' => '#ffff00',
	'position' => 'absolute',
  	'marginTop' => -75,
	'marginLeft' => 150,
	'textContent' => $txtboxContent,
);
$docx->addShape('oval', $options);

$docx->createDocx(__DIR__ . '/example_addShape_2');