<?php
// add a comment to a text using WordFragments

require_once __DIR__ . '/../../../Classes/Phpdocx/Create/CreateDocx.php';

$docx = new Phpdocx\Create\CreateDocx();

$textDocumentFragment = new Phpdocx\Elements\WordFragment($docx, 'comment');
$textDocumentFragment->addText('custom comment', array('bold' => true, 'fontSize' => 14));
$textCommentFragment = new Phpdocx\Elements\WordFragment($docx, 'comment');
$textCommentFragment->addText('The comment we want to insert.', array('bold' => true));

$comment = new Phpdocx\Elements\WordFragment($docx, 'document');
$comment->addComment(
    array(
        'textDocument' => $textDocumentFragment,
        'textComment' => $textCommentFragment,
        'initials' => 'PT',
        'author' => 'PHPDocX Team',
        'date' => '10 September 2000'
    )
);

$text = array();
$text[] = array('text' => 'Here comes the ');
$text[] = $comment;
$text[] = array('text' => ' and some other text.');

$docx->addText($text);

$docx->createDocx(__DIR__ . '/example_addComment_4');