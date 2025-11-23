<?php

/** 
 * @var app\model\Author $author
 * @var boolean $canEdit
 * @var boolean $canDelete
 * @var boolean $canSubscribe
 */

use yii\helpers\Html;
?>
<div class="col-lg-offset-1 col-lg-11">
    <?
        if ($canEdit) {
            echo Html::a('Edit Author', ['/author/edit/' . $author->id], ['class' => 'btn']);
        }
    ?>
</div>
<div class="col-lg-offset-1 col-lg-11">
    <?
        if ($canDelete) {
            echo Html::a('Delete Author', ['/author/delete/' . $author->id], ['class' => 'btn']);
        }
    ?>
</div>
<div class="col-lg-offset-1 col-lg-11">
    <?
        if ($canSubscribe) {
            echo Html::a('Subscribe To Author', ['/author/subscribe/' . $author->id], ['class' => 'btn']);
        }
    ?>
</div>
<br>
<br>
<div class="col-lg-offset-1 col-lg-11">
    <?= 'Fio: ' . $author->fio ?>
</div>