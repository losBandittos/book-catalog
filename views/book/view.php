<?php

/** 
 * @var app\model\Book $book
 * @var boolean $canViewAuthor
 * @var boolean $canEdit
 * @var boolean $canDelete
 */

use yii\helpers\Html;
?>

<div class="col-lg-offset-1 col-lg-11">
<?
    if ($canEdit) {
        echo Html::a('Edit Book', ['/book/edit/' . $book->id], ['class' => 'btn']);
    }
?>
</div>
<div class="col-lg-offset-1 col-lg-11">
<?
    if ($canDelete) {
        echo Html::a('Delete Book', ['/book/delete/' . $book->id], ['class' => 'btn']);
    }
?>
</div>
<br>
<br>
<div class="col-lg-offset-1 col-lg-11">
    <?= 'Title: ' . $book->title ?>
</div>
<div class="col-lg-offset-1 col-lg-11">
    <?= 'Authors: ' . ($canViewAuthor ? $book->authorLinks : $book->authorFios) ?>
</div>
<div class="col-lg-offset-1 col-lg-11">
    <?= 'Year: ' . $book->year ?>
</div>
<div class="col-lg-offset-1 col-lg-11">
    <?= 'Isbn: ' . $book->isbn ?>
</div>
<div class="col-lg-offset-1 col-lg-11">
    <?= 'Cover_link: ' . $book->cover_link ?>
</div>