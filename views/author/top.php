<?php

/** 
 * @var yii\web\View $this
 * @var app\models\TopForm $topForm
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Top Authors';
?>
<div class="card" style="width: 50%; float: left;">
    <?
        $form = ActiveForm::begin([
            'id' => 'top-form',
            'options' => ['class' => 'form-horizontal'],
        ])
    ?>
        <?= $form->field($topForm, 'year') ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Показать Топ', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end() ?>
</div>

<div class="card" style="width: 50%; float: right;">
    <?
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'fio',
                    'content' => function ($author) {
                        return Html::a($author->fio, Url::to(['author/view/' . $author->id]));
                    }
                ],
                'book_count'
            ],
        ]);
    ?>
</div>