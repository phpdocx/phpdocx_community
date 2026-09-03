<?php
// add shapes

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$docx->addText('Straight arrow:');

$options = array(
    'width' => 70,
    'height' => 70,
    'fillcolor' => '#555555',
    'strokecolor' => '#ff0000',
    'strokeweight' => 4,
    'rotation' => -45,
);
$docx->addShape('straightArrow', $options);

$docx->addText('Arrow left:');

$options = array(
    'width' => 150,
    'height' => 30,
    'fillcolor' => '#FF0000',
    'opacity' => 60,
);
$docx->addShape('arrowLeft', $options);

$docx->addText('Arrow right:');

$options = array(
    'width' => 150,
    'height' => 30,
    'fillcolor' => '#0000FF',
    'opacity' => 30,
);
$docx->addShape('arrowRight', $options);

$docx->addText('Custom shape type:');

$options = array(
    'width' => 200,
    'height' => 200,
    'customShape' => '<v:shapetype adj="10800" coordsize="21600,21600" id="_x0000_t5" o:spt="5" path="m@0,l,21600r21600,xe"><v:stroke joinstyle="miter"/><v:formulas><v:f eqn="val #0"/><v:f eqn="prod #0 1 2"/><v:f eqn="sum @1 10800 0"/></v:formulas><v:path gradientshapeok="t" o:connectlocs="@0,0;@1,10800;0,21600;10800,21600;21600,21600;@2,10800" o:connecttype="custom" textboxrect="0,10800,10800,18000;5400,10800,16200,18000;10800,10800,21600,18000;0,7200,7200,21600;7200,7200,14400,21600;14400,7200,21600,21600"/><v:handles><v:h position="#0,topLeft" xrange="0,21600"/></v:handles></v:shapetype>',
    'fillcolor' => '#FF00FF',
    'type' => '#_x0000_t5',
);
$docx->addShape('customShape', $options);

$docx->createDocx(__DIR__ . '/example_addShape_4');