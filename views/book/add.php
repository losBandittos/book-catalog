<?php

/** 
 * @var app\model\Book $book
 * @var yii\data\ActiveDataProvider $authorsDataProvider
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="card" style="width: 50%; float: left;">
    <?
        $form = ActiveForm::begin([
            'id' => 'book-form',
            'options' => ['class' => 'form-horizontal'],
        ]);
    ?>
    <?= $form->field($book, 'title') ?>
    <?= $form->field($book, 'author_ids')->hint('Use , as separator') ?>
    <?= $form->field($book, 'year') ?>
    <?= $form->field($book, 'isbn') ?>
    <?= $form->field($book, 'cover_link') ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>

<div class="card" style="width: 50%; float: right;">
    <?= $this->render('_authors', [
        'dataProvider' => $authorsDataProvider,
    ]) ?>
</div>