<?php

/** 
 * @var app\model\Author $author
 * @var boolean $canDelete
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?
    if ($canDelete) {
        echo Html::a('Delete Author', ['/author/delete/' . $author->id], ['class' => 'btn']);
    }
?>
<br>
<br>
<br>
<?
    $form = ActiveForm::begin([
        'id' => 'author-form',
        'options' => ['class' => 'form-horizontal'],
    ])
?>
    <?= $form->field($author, 'fio') ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>