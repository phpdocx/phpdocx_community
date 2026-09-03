<?php
// add shapes with image contents

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$docx->addText('Curve:');

$options = array(
	'width' => 60,
	'height' => 60,
	'from' => '300,40',
	'to' => '120,150',
	'fillcolor' => '#555555',
	'strokecolor' => '#ff0000',
	'strokeweight' => '4',
	'control1' => '60,70',
	'control2' => '125,170',
	'imageContent' => __DIR__ . '/../../files/image.png',
);
$docx->addShape('curve', $options);

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
	'imageContent' => __DIR__ . '/../../files/image.png',
);

$docx->addShape('rect', $options);

$docx->addBreak(array('type' => 'line', 'number' => 5));

$docx->addText('An oval with no fill color and a circle with yellow color:');

$docx->addBreak(array('type' => 'line', 'number' => 3));

$options = array(
	'width' => 100,
	'height' => 100,
	'strokecolor' => '#000000',
	'strokeweight' => '2',
	'fillcolor' => '#ffff00',
	'position' => 'absolute',
  	'marginTop' => -75,
	'marginLeft' => 150,
	'imageContent' => __DIR__ . '/../../files/image.png',
);
$docx->addShape('oval', $options);

$docx->createDocx(__DIR__ . '/example_addShape_3');