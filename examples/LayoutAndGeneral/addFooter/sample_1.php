<?php
// add a footer

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

// create a Word fragment with an image to be inserted in the header of the document
$imageOptions = array(
	'src' => __DIR__ . '/../../files/image.png',
	'dpi' => 300,
);

$footerImage = new Phpdocx\Elements\WordFragment($docx, 'defaultFooter');
$footerImage->addImage($imageOptions);

$docx->addFooter(array('default' => $footerImage));
// add some text
$docx->addText('This document has a footer with just one image.');

$docx->createDocx(__DIR__ . '/example_addFooter_1');