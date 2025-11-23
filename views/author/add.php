<?php

/** 
 * @var app\model\Author $author
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
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