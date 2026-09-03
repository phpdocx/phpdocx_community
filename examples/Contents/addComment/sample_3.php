<?php
// add multiple comments to a text

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$comment = new Phpdocx\Elements\WordFragment($docx, 'document');

$comment->addComment(
    array(
        'textDocument' => 'comment',
        'textComments' => array(
            array(
                'textComment' => 'First comment.',
                'initials' => 'PT',
                'author' => 'PHPDocX Team',
                'date' => '10 September 2000',
            ),
            array(
                'textComment' => 'Second comment.',
                'initials' => 'OT',
                'author' => 'Other Team',
                'date' => '20 September 2021',
            ),
            array(
                'textComment' => 'New comment.',
                'initials' => 'NT',
                'author' => 'New Team',
                'date' => '20 October 2021',
            ),
        )
    )
);

$text = array();
$text[] = array('text' => 'Here comes the ');
$text[] = $comment;
$text[] = array('text' => ' and some other text.');

$docx->addText($text);

$docx->createDocx(__DIR__ . '/example_addComment_3');